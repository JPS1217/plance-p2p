<?php
session_start();


$gwm = $_SESSION['gwm_result'] ?? null;
unset($_SESSION['gwm_result']);

if (!$gwm) {
    header("Location: ../index.php");
    exit();
}

$status       = $gwm['status']       ?? 'FAILED';
$nuevo_estado = $gwm['estado']       ?? 'rechazada';
$producto     = $gwm['producto']     ?? '';
$precio       = (float) ($gwm['precio']       ?? 0);
$monto_pagar  = (float) ($gwm['monto_pagar']  ?? 0);
$monto_pagado = (float) ($gwm['monto_pagado'] ?? 0);
$correo       = $gwm['correo']       ?? '';
$nombre       = $gwm['nombre']       ?? '';
$orden_id     = $gwm['orden_id']     ?? '';
$message      = $gwm['message']      ?? '';
$reference    = $gwm['reference']    ?? '';

$saldo_rest = max(0, $precio - $monto_pagado);
$completado = $saldo_rest <= 0;

if ($status === 'APPROVED') {
    $icono   = '✅'; $titulo  = $completado ? '¡Orden completada!' : '¡Abono aprobado!';
    $mensaje = $completado
        ? 'Ya pagaste el total de tu compra. ¡Disfruta tus Esmeraldas!'
        : 'Tu abono fue procesado exitosamente. Aún queda saldo pendiente.';
    $color   = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
} elseif ($status === 'PENDING') {
    $icono   = '⏳'; $titulo  = 'Abono pendiente';
    $mensaje = 'Tu abono está siendo procesado. Te notificaremos pronto.';
    $color   = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} else {
    $icono   = '❌'; $titulo  = 'Abono rechazado';
    $mensaje = !empty($message) ? $message : 'Este abono no pudo ser procesado. Verifica los datos e intenta de nuevo.';
    $color   = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Esmeraldas Mixto</title>
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
            --ret-ctx-color: #a855f7;
            --ret-ctx-rgb:   168, 85, 247;
        }
    </style>
</head>
<body>
    <div class="result-card">
        <?php if ($status === 'PENDING'): ?>
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
        <p class="result-message"><?= htmlspecialchars($mensaje) ?></p>

        <div class="gw-badge">
            <i class="bi bi-shuffle"></i>
            Pago Mixto · API Gateway · Evertec PlacetoPay
        </div>

        <div class="order-details">
            <div class="order-row">
                <span>Orden #</span>
                <span>#<?= htmlspecialchars($orden_id) ?></span>
            </div>
            <div class="order-row">
                <span>Producto</span>
                <span><?= htmlspecialchars($producto) ?></span>
            </div>
            <div class="order-row">
                <span>Nombre</span>
                <span><?= htmlspecialchars($nombre) ?></span>
            </div>
            <div class="order-row">
                <span>Correo</span>
                <span><?= htmlspecialchars($correo) ?></span>
            </div>
            <div class="order-row">
                <span>Total del pedido</span>
                <span>$<?= number_format($precio, 0, ',', '.') ?> COP</span>
            </div>
            <div class="order-row">
                <span>Este abono</span>
                <span style="color:<?= $color ?>; font-size:1.1rem;">
                    $<?= number_format($monto_pagar, 0, ',', '.') ?> COP
                </span>
            </div>
            <div class="order-row">
                <span>Pagado hasta ahora</span>
                <span>$<?= number_format($monto_pagado, 0, ',', '.') ?> COP</span>
            </div>
            <div class="order-row">
                <span>Saldo pendiente</span>
                <span style="<?= $completado ? '' : 'color:#f0b429;font-weight:700;' ?>">
                    <?= $completado ? '— Completo' : '$' . number_format($saldo_rest, 0, ',', '.') . ' COP' ?>
                </span>
            </div>
            <?php if (!empty($reference)): ?>
            <div class="order-row">
                <span>Referencia</span>
                <span style="font-size:0.78rem; color:var(--pt-text-sec);"><?= htmlspecialchars($reference) ?></span>
            </div>
            <?php endif; ?>
            <div class="order-row">
                <span>Estado</span>
                <span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span>
            </div>
        </div>

        <?php if (!$completado): ?>
        <a href="../views/games/bloodstrike.php?orden=<?= urlencode((string) $orden_id) ?>" class="btn-home">
            <i class="bi bi-play-circle-fill"></i> Continuar pago
        </a>
        <a href="../index.php" class="btn-volver">← Inicio</a>
        <?php else: ?>
        <a href="../index.php" class="btn-home">← Inicio</a>
        <?php endif; ?>
        <a href="../views/games/juegos.php" class="btn-volver">Volver al comercio</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
