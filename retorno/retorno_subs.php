<?php
session_start();


require_once '../php/env.php';

// ══════════════════════════════════════════
// Recibir sub_id desde la URL
// ══════════════════════════════════════════
$sub_id = intval($_GET['sub'] ?? 0);

if (!$sub_id) {
    header("Location: ../index.php");
    exit();
}

// Sin base de datos: request_id e info los dejó crear_subs en sesión
$row        = $_SESSION['sub_info'] ?? null;
$request_id = $_SESSION['sub_requestId'] ?? '';

if (!$request_id) {
    header("Location: ../index.php");
    exit();
}

// ══════════════════════════════════════════
// Consultar estado a PlaceToPay
// ══════════════════════════════════════════
$login     = "2d9eaf1e662518756a3d78806543af5b";
$secretKey = "3YC5brb5eAR4xBGQ";
$url       = "https://checkout-test.placetopay.com/api/session/" . $request_id;

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$auth = [
    "auth" => [
        "login"   => $login,
        "tranKey" => $tranKey,
        "nonce"   => $nonceB64,
        "seed"    => $seed
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($auth));
curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// ══════════════════════════════════════════
// Determinar estado del pago
// ══════════════════════════════════════════
$status_p2p = $result['status']['status'] ?? 'UNKNOWN';

if ($status_p2p === 'APPROVED') {
    $nuevo_estado = 'aprobada';
    $icono        = '✅';
    $color        = '#3ecf8e';
    $bg_icon      = 'rgba(62, 207, 142, 0.15)';
    $color_rgb    = '62, 207, 142';
} elseif ($status_p2p === 'REJECTED') {
    $nuevo_estado = 'rechazada';
    $icono        = '❌';
    $titulo       = 'Pago rechazado';
    $mensaje      = 'Tu pago no pudo ser procesado. Intenta de nuevo.';
    $color        = '#e05252';
    $bg_icon      = 'rgba(224, 82, 82, 0.15)';
    $color_rgb    = '224, 82, 82';
} elseif ($status_p2p === 'PENDING') {
    $nuevo_estado = 'pendiente';
    $icono        = '⏳';
    $titulo       = 'Pago pendiente';
    $mensaje      = 'Tu pago está siendo procesado. Te notificaremos pronto.';
    $color        = '#f0b429';
    $bg_icon      = 'rgba(240, 180, 41, 0.15)';
    $color_rgb    = '240, 180, 41';
} else {
    $nuevo_estado = 'cancelada';
    $icono        = '🚫';
    $titulo       = 'Suscripción cancelada';
    $mensaje      = 'Cancelaste el proceso de pago.';
    $color        = '#8a8d96';
    $bg_icon      = 'rgba(138, 141, 150, 0.15)';
    $color_rgb    = '138, 141, 150';
}

// ══════════════════════════════════════════
// Sin base de datos: no se persiste estado ni token.
// ══════════════════════════════════════════

// ══════════════════════════════════════════
// Extraer token de la respuesta de PlaceToPay
// ══════════════════════════════════════════
$token = '';

// Caso 1 — Tarjeta nueva: token en subscription.instrument
if (isset($result['subscription']['instrument']) && is_array($result['subscription']['instrument'])) {
    foreach ($result['subscription']['instrument'] as $item) {
        if (($item['keyword'] ?? '') === 'token') {
            $token = $item['value'] ?? '';
            break;
        }
    }
}

// Caso 2 — Tarjeta guardada: token en payment[0].subscription
if (empty($token) && isset($result['payment'][0]['subscription']) && is_array($result['payment'][0]['subscription'])) {
    foreach ($result['payment'][0]['subscription'] as $item) {
        if (($item['keyword'] ?? '') === 'token') {
            $token = $item['value'] ?? '';
            break;
        }
    }
}

// Caso 3 — Buscar en processorFields de payment[0] por si acaso
if (empty($token) && isset($result['payment'][0]['processorFields']) && is_array($result['payment'][0]['processorFields'])) {
    foreach ($result['payment'][0]['processorFields'] as $item) {
        if (($item['keyword'] ?? '') === 'token') {
            $token = $item['value'] ?? '';
            break;
        }
    }
}

// Sin base de datos: el token queda sólo en memoria para esta pantalla.

// ── Definir título y mensaje según si hay token ──
if ($status_p2p === 'APPROVED') {
    if (!empty($token)) {
        $titulo  = '¡Suscripción activada!';
        $mensaje = 'Tu suscripción fue procesada y tu tarjeta quedó guardada para futuros cobros. ¡Disfrútala!';
    } else {
        $titulo  = '¡Pago aprobado!';
        $mensaje = 'Tu pago fue exitoso. Guarda tu tarjeta para activar la suscripción completa y agilizar futuros pagos.';
    }
}

// Obtener info de la suscripción (ya la tenemos en $row)
$subs = $row;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de suscripción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <?php require_once dirname(__DIR__) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../assets/css/styles-retorno.css">
    <style>
        :root {
            --ret-color:     <?= $color ?>;
            --ret-bg-icon:   <?= $bg_icon ?>;
            --ret-color-rgb: <?= $color_rgb ?>;
            --ret-maxw:      460px;
        }
    </style>
</head>
<body>
    <div class="result-card">

        <?php if ($status_p2p === 'PENDING'): ?>
        <div class="result-icon">
            <div class="pending-spinner">
                <div class="pending-ring"></div>
                <div class="pending-dots">
                    <span class="pending-dot"></span>
                    <span class="pending-dot"></span>
                    <span class="pending-dot"></span>
                </div>
            </div>
        </div>
        <div class="pending-label">Procesando...</div>
        <?php else: ?>
        <div class="result-icon"><?= $icono ?></div>
        <?php endif; ?>
        <div class="result-title"><?= $titulo ?></div>
        <p class="result-message"><?= $mensaje ?></p>

        <?php if ($nuevo_estado === 'aprobada' && empty($token)): ?>
        <a href="../php/tokenizar.php?sub=<?= $sub_id ?>" class="btn-tokenizar">
            🔐 Guardar tarjeta para futuros cobros
        </a>
        <?php endif; ?>

        <?php if ($nuevo_estado === 'aprobada' && !empty($token)): ?>
        <div class="token-box">
            🔐 <strong>Tarjeta guardada</strong> — Tus próximos pagos serán automáticos.
        </div>
        <?php endif; ?>

        <?php if ($subs): ?>
        <div class="order-details">
            <div class="order-row">
                <span>Suscripción #</span>
                <span><?= htmlspecialchars($subs['id']) ?></span>
            </div>
            <div class="order-row">
                <span>Plataforma</span>
                <span><?= htmlspecialchars($subs['plataforma']) ?></span>
            </div>
            <div class="order-row">
                <span>Plan</span>
                <span><?= htmlspecialchars($subs['plan']) ?></span>
            </div>
            <div class="order-row">
                <span>Correo</span>
                <span><?= htmlspecialchars($subs['usuario_id']) ?></span>
            </div>
            <div class="order-row">
                <span>Total</span>
                <span>$<?= number_format($subs['precio'], 0, ',', '.') ?> COP</span>
            </div>
            <div class="order-row">
                <span>Estado</span>
                <span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span>
            </div>
        </div>
        <?php endif; ?>

        <a href="../sesiones.php" class="btn-home">← Inicio</a>
        <a href="../views/plataformas/suscripciones.php" class="btn-volver">Volver al comercio</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/validaciones.js"></script>
</body>
</html>
