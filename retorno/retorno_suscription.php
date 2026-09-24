<?php
session_start();


require_once '../php/env.php';

$sub_id = intval($_GET['sub'] ?? 0);
if (!$sub_id) { header("Location: ../index.php"); exit(); }

// Sin base de datos: request_id e info los dejó crear_suscription en sesión
$row        = $_SESSION['sus_info'] ?? null;
$request_id = $_SESSION['sus_requestId'] ?? '';

if (!$request_id) { header("Location: ../index.php"); exit(); }

// Consultar estado a PlaceToPay
$login     = "2d9eaf1e662518756a3d78806543af5b";
$secretKey = "3YC5brb5eAR4xBGQ";
$url       = "https://checkout-test.placetopay.com/api/session/" . $request_id;

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS,    json_encode(["auth" => ["login" => $login, "tranKey" => $tranKey, "nonce" => $nonceB64, "seed" => $seed]]));
curl_setopt($ch, CURLOPT_HTTPHEADER,    ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$response = curl_exec($ch);
curl_close($ch);

$result     = json_decode($response, true);
$status_p2p = $result['status']['status'] ?? 'UNKNOWN';

// Extraer token
$token = '';
if (isset($result['subscription']['instrument']) && is_array($result['subscription']['instrument'])) {
    foreach ($result['subscription']['instrument'] as $item) {
        if (($item['keyword'] ?? '') === 'token') { $token = $item['value'] ?? ''; break; }
    }
}

// Determinar estado y mensajes
if ($status_p2p === 'APPROVED') {
    $nuevo_estado = 'aprobada';
    if (!empty($token)) {
        $icono = '🔐'; $titulo = '¡Tarjeta registrada!';
        $mensaje = 'Tu tarjeta fue tokenizada exitosamente. Tu suscripción está activa.';
    } else {
        $icono = '✅'; $titulo = '¡Suscripción activada!';
        $mensaje = 'Tu suscripción fue procesada correctamente.';
    }
    $color = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
} elseif ($status_p2p === 'REJECTED') {
    $nuevo_estado = 'rechazada';
    $icono = '❌'; $titulo = 'Proceso rechazado';
    $mensaje = 'No se pudo procesar. Intenta de nuevo.';
    $color = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
} elseif ($status_p2p === 'PENDING') {
    $nuevo_estado = 'pendiente';
    $icono = '⏳'; $titulo = 'Proceso pendiente';
    $mensaje = 'Tu solicitud está siendo procesada.';
    $color = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} else {
    $nuevo_estado = 'cancelada';
    $icono = '🚫'; $titulo = 'Proceso cancelado';
    $mensaje = 'Cancelaste el proceso.';
    $color = '#8a8d96'; $bg_icon = 'rgba(138,141,150,0.15)'; $color_rgb = '138, 141, 150';
}

// Sin base de datos: no se persiste estado ni token.

$subs = $row;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Suscripción</title>
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

        <?php if ($nuevo_estado === 'aprobada' && !empty($token)): ?>
        <div class="token-box">
            <i class="bi bi-shield-lock-fill"></i>
            <span>🔐 <strong>Tarjeta tokenizada</strong> — Tu medio de pago quedó registrado de forma segura para futuros cobros.</span>
        </div>
        <?php endif; ?>

        <?php if ($subs): ?>
        <div class="order-details">
            <div class="order-row"><span>Suscripción #</span><span>#<?= htmlspecialchars($subs['id']) ?></span></div>
            <div class="order-row"><span>Servicio</span><span><?= htmlspecialchars($subs['servicio']) ?></span></div>
            <div class="order-row"><span>Plan</span><span><?= htmlspecialchars($subs['plan']) ?></span></div>
            <div class="order-row"><span>Correo</span><span><?= htmlspecialchars($subs['usuario_id']) ?></span></div>
            <div class="order-row"><span>Precio</span><span>$<?= number_format($subs['precio'], 0, ',', '.') ?> COP</span></div>
            <div class="order-row"><span>Token</span><span style="color:<?= !empty($token) ? '#3ecf8e' : '#8a8d96' ?>;"><?= !empty($token) ? '✅ Guardado' : '— No tokenizado' ?></span></div>
            <div class="order-row"><span>Estado</span><span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span></div>
        </div>
        <?php endif; ?>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/plataformas/suscripciones.php" class="btn-volver">Volver al comercio</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
