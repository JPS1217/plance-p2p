<?php
session_start();


require_once '../php/env.php';

$data      = $_SESSION['continuar_result'] ?? null;
$orden_id  = $_GET['orden_id'] ?? ($data['orden_id'] ?? '');

if (!$orden_id || !$data) { header("Location: ../index.php"); exit(); }

// Sin base de datos: datos de la orden desde la sesión que dejó continuar_pago
$row          = $data;
$total        = (float)($data['precio'] ?? 0);
$monto_previo = (float)($data['monto_pagado'] ?? 0);
$saldo_rest   = $total - $monto_previo;
$requestId    = $data['requestId'] ?? null;

unset($_SESSION['continuar_result']);

// Consultar estado en PlacetoPay
$nuevo_estado = 'pendiente';
$monto_ahora  = 0;

if ($requestId) {
    $login     = "2d9eaf1e662518756a3d78806543af5b";
    $secretKey = "3YC5brb5eAR4xBGQ";
    $seed      = date('c');
    $nonce     = bin2hex(random_bytes(16));
    $tranKey   = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
    $nonceB64  = base64_encode($nonce);

    $ch = curl_init("https://checkout-test.placetopay.com/api/session/{$requestId}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,           true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode(["auth" => ["login" => $login, "tranKey" => $tranKey, "nonce" => $nonceB64, "seed" => $seed]]));
    curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT,        15);
    $resp = curl_exec($ch);
    curl_close($ch);

    $rdata       = json_decode($resp, true);
    $gw_status   = $rdata['status']['status'] ?? 'PENDING';

    if (!empty($rdata['payment'])) {
        $pago       = $rdata['payment'][0] ?? [];
        $monto_ahora = (float)($pago['amount']['from']['total'] ?? $saldo_rest);
        $gw_status  = $pago['status']['status'] ?? $gw_status;
    } else {
        $monto_ahora = $saldo_rest;
    }

    $nuevo_estado = match($gw_status) {
        'APPROVED' => 'aprobada',
        'PENDING'  => 'pendiente',
        default    => 'rechazada'
    };

    // Sin base de datos: sumar el nuevo monto sólo para la vista.
    if ($nuevo_estado === 'aprobada') {
        $nuevo_monto = $monto_previo + $monto_ahora;
        $saldo_final = $total - $nuevo_monto;
    } else {
        $nuevo_monto = $monto_previo;
        $saldo_final = $saldo_rest;
    }
} else {
    $nuevo_monto = $monto_previo;
    $saldo_final = $saldo_rest;
    $monto_ahora = $saldo_rest;
}

// Colores
if ($nuevo_estado === 'aprobada') {
    $icono = $saldo_final <= 0 ? '🎉' : '✅';
    $titulo = $saldo_final <= 0 ? '¡Pago completado!' : '¡Abono registrado!';
    $mensaje = $saldo_final <= 0
        ? '¡Excelente! Completaste el pago total de tu pedido.'
        : 'Tu abono fue registrado. Aún tienes un saldo pendiente.';
    $color = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
} elseif ($nuevo_estado === 'pendiente') {
    $icono = '⏳'; $titulo = 'Pago pendiente';
    $mensaje = 'Tu pago está siendo procesado.';
    $color = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} else {
    $icono = '❌'; $titulo = 'Pago rechazado';
    $mensaje = 'No se pudo procesar el pago. Por favor intenta de nuevo.';
    $color = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Continuación de pago</title>
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
            --ret-ctx-color: #93c5fd;
            --ret-ctx-rgb:   59, 130, 246;
        }
    </style>
</head>
<body>
    <div class="result-card">
        <?php if ($nuevo_estado === 'pendiente'): ?>
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
            Continuación de pago mixto · Web Checkout · PlacetoPay
        </div>

        <!-- Desglose actualizado -->
        <div class="breakdown">
            <div class="breakdown-title">Desglose del pago</div>
            <div class="breakdown-row">
                <span>Total del pedido</span>
                <span style="font-weight:700;">$<?= number_format($total, 0, ',', '.') ?> COP</span>
            </div>
            <div class="breakdown-row">
                <span>Abono anterior</span>
                <span style="color:#8a8d96;">$<?= number_format($monto_previo, 0, ',', '.') ?> COP</span>
            </div>
            <div class="breakdown-row">
                <span>Abono ahora</span>
                <span style="color:#3ecf8e;font-weight:700;">$<?= number_format($monto_ahora, 0, ',', '.') ?> COP</span>
            </div>
            <div class="breakdown-row">
                <span style="font-weight:700;">Saldo restante</span>
                <span style="color:<?= $saldo_final <= 0 ? '#3ecf8e' : '#f0b429' ?>;font-weight:800;font-size:1rem;">
                    <?= $saldo_final <= 0 ? '✅ $0 — Pagado completo' : '$' . number_format($saldo_final, 0, ',', '.') . ' COP' ?>
                </span>
            </div>
        </div>

        <div class="order-details">
            <div class="order-row"><span>Orden #</span><span>#<?= $orden_id ?></span></div>
            <div class="order-row"><span>Producto</span><span style="font-size:0.82rem;"><?= htmlspecialchars($row['producto']) ?></span></div>
            <div class="order-row">
                <span>Estado</span>
                <span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span>
            </div>
        </div>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/historial/reg-pgb.php?modo=mixto" class="btn-volver">Ver historial</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
