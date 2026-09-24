<?php
session_start();


require_once '../php/env.php';

$mix = $_SESSION['mix_result'] ?? null;
unset($_SESSION['mix_result']);

if (!$mix) {
    header("Location: ../index.php");
    exit();
}

$orden_id      = $mix['orden_id']      ?? 0;
$productos     = $mix['productos']     ?? '';
$total         = $mix['total']         ?? 0;
$monto_parcial = $mix['monto_parcial'] ?? $total;
$allow_partial = $mix['allow_partial'] ?? false;
$reference     = $mix['reference']     ?? '';
$requestId     = $mix['requestId']     ?? null;
$mix_status    = $mix['status']        ?? 'FAILED';

// Si venimos del checkout de PlacetoPay, consultamos el estado real
$nuevo_estado  = 'pendiente';
$estado_final  = 'PENDING';
$monto_pagado  = null;

if ($requestId) {
    $login     = "2d9eaf1e662518756a3d78806543af5b";
    $secretKey = "3YC5brb5eAR4xBGQ";
    $seed      = date('c');
    $nonce     = bin2hex(random_bytes(16));
    $tranKey   = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
    $nonceB64  = base64_encode($nonce);

    $queryBody = json_encode([
        "auth" => ["login" => $login, "tranKey" => $tranKey, "nonce" => $nonceB64, "seed" => $seed]
    ]);

    $ch = curl_init("https://checkout-test.placetopay.com/api/session/{$requestId}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,           true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $queryBody);
    curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT,        15);
    $resp   = curl_exec($ch);
    curl_close($ch);

    $data         = json_decode($resp, true);
    $estado_final = $data['status']['status'] ?? 'PENDING';

    // Si tiene transacciones, tomamos el monto pagado real
    if (!empty($data['payment'])) {
        $pago         = $data['payment'][0] ?? [];
        $monto_pagado = $pago['amount']['from']['total'] ?? $monto_parcial;
        $estado_final = $pago['status']['status'] ?? $estado_final;
    }

    $nuevo_estado = match($estado_final) {
        'APPROVED' => 'aprobada',
        'PENDING'  => 'pendiente',
        default    => 'rechazada'
    };

    // Sin base de datos: no se persiste el estado.
}

// Colores según estado
if ($estado_final === 'APPROVED') {
    $icono = '✅'; $titulo = '¡Pago aprobado!';
    $color = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
    $mensaje = $allow_partial
        ? '¡Pago parcial procesado exitosamente! El saldo restante quedará pendiente.'
        : '¡Tu pago fue procesado exitosamente!';
} elseif ($estado_final === 'PENDING') {
    $icono = '⏳'; $titulo = 'Pago pendiente';
    $color = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
    $mensaje = 'Tu pago está siendo procesado. Te notificaremos cuando se complete.';
} else {
    $icono = '❌'; $titulo = 'Pago rechazado';
    $color = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
    $mensaje = 'No se pudo procesar el pago. Por favor intenta de nuevo.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Pago Mixto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <?php require_once dirname(__DIR__) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../assets/css/styles-retorno.css">
    <style>
        :root {
            --ret-color:     <?= $color ?>;
            --ret-bg-icon:   <?= $bg_icon ?>;
            --ret-color-rgb: <?= $color_rgb ?>;
            --ret-ctx-color: #93c5fd;
            --ret-ctx-rgb:   59, 130, 246;
        }
    </style>
</head>
<body>
    <div class="result-card">
        <?php if ($estado_final === 'PENDING'): ?>
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
        <p class="result-msg"><?= $mensaje ?></p>

        <div class="mix-badge">
            <i class="bi bi-shuffle"></i>
            <?= $allow_partial ? 'Pago <strong>mixto / parcial</strong> · Web Checkout · PlacetoPay' : 'Pago <strong>múltiple</strong> · Web Checkout · PlacetoPay' ?>
        </div>

        <?php if ($allow_partial): ?>
        <div class="pago-breakdown">
            <div class="breakdown-title">Desglose del pago</div>
            <div class="breakdown-row">
                <span>Total del pedido</span>
                <span>$<?= number_format($total, 0, ',', '.') ?> COP</span>
            </div>
            <div class="breakdown-row">
                <span>Monto pagado ahora</span>
                <span style="color:<?= $color ?>;">$<?= number_format($monto_pagado ?? $monto_parcial, 0, ',', '.') ?> COP</span>
            </div>
            <div class="breakdown-row">
                <span>Saldo restante</span>
                <span style="color:#f0b429;">$<?= number_format($total - ($monto_pagado ?? $monto_parcial), 0, ',', '.') ?> COP</span>
            </div>
        </div>
        <?php endif; ?>

        <div class="order-details">
            <div class="order-row"><span>Orden #</span><span>#<?= $orden_id ?></span></div>
            <div class="order-row"><span>Productos</span><span style="font-size:0.8rem;text-align:right;max-width:60%;"><?= htmlspecialchars($productos) ?></span></div>
            <div class="order-row"><span>Referencia</span><span style="font-size:0.78rem;color:var(--pt-text-sec);"><?= htmlspecialchars($reference) ?></span></div>
            <div class="order-row">
                <span>Estado</span>
                <span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span>
            </div>
        </div>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/games/juegos.php" class="btn-volver">Volver al comercio</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
