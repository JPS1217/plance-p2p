<?php
session_start();


require_once '../php/env.php';

// ══════════════════════════════════════════
// Recibir order_id desde la URL
// ══════════════════════════════════════════
$order_id   = intval($_GET['order'] ?? 0);
$request_id = $_SESSION['p2p_requestId'] ?? '';

if (!$order_id || !$request_id) {
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

// Mapear estado de PlaceToPay a nuestro estado en BD
if ($status_p2p === 'APPROVED') {
    $nuevo_estado = 'aprobada';
    $icono        = '✅';
    $titulo       = '¡Pago aprobado!';
    $mensaje      = 'Tu recarga fue procesada exitosamente.';
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
    // CANCELED u otro
    $nuevo_estado = 'cancelada';
    $icono        = '🚫';
    $titulo       = 'Pago cancelado';
    $mensaje      = 'Cancelaste el proceso de pago.';
    $color        = '#8a8d96';
    $bg_icon      = 'rgba(138, 141, 150, 0.15)';
    $color_rgb    = '138, 141, 150';
}

// ══════════════════════════════════════════
// Sin base de datos: no se persiste el estado.
// Detalle de la orden a partir de lo que dejó crear_orden en sesión (si existe).
// ══════════════════════════════════════════
$orden = $_SESSION['p2p_orden_info'] ?? null;

// Limpiar sesión de P2P
unset($_SESSION['p2p_requestId'], $_SESSION['p2p_order_id'], $_SESSION['p2p_orden_info']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Barlow:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>
    <?php require_once dirname(__DIR__) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../assets/css/styles-retorno.css">
    <style>
        :root {
            --ret-color:     <?= $color ?>;
            --ret-bg-icon:   <?= $bg_icon ?>;
            --ret-color-rgb: <?= $color_rgb ?>;
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

        <?php if ($orden): ?>
        <div class="order-details">
            <div class="order-row">
                <span>Orden #</span>
                <span><?= htmlspecialchars($orden['id']) ?></span>
            </div>
            <div class="order-row">
                <span>Producto</span>
                <span><?= htmlspecialchars($orden['producto']) ?></span>
            </div>
            <div class="order-row">
                <span>ID Jugador</span>
                <span><?= htmlspecialchars($orden['jugador_id']) ?></span>
            </div>
            <div class="order-row">
                <span>Total</span>
                <span>$<?= number_format($orden['precio'], 0, ',', '.') ?> COP</span>
            </div>
            <div class="order-row">
                <span>Estado</span>
                <span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span>
            </div>
        </div>
        <?php endif; ?>

        <a href="../views/games/juegos.php" class="btn-home">← Volver al comercio</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if (typeof anime !== 'undefined') {
            // Entrada de la card de detalles
            anime({
                targets: '.order-row',
                opacity: [0, 1],
                translateX: [-10, 0],
                delay: anime.stagger(70, { start: 200 }),
                duration: 450,
                easing: 'easeOutQuad'
            });
        }
    </script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/validaciones.js"></script>
</body>
</html>
