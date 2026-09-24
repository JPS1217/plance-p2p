<?php
session_start();


// Obtener resultado de sesión
$gw = $_SESSION['gw_result'] ?? null;
unset($_SESSION['gw_result']);

if (!$gw) {
    header("Location: ../index.php");
    exit();
}

$status      = $gw['status']    ?? 'FAILED';
$nuevo_estado = $gw['estado']   ?? 'rechazada';
$producto    = $gw['producto']  ?? '';
$precio      = $gw['precio']    ?? 0;
$correo      = $gw['correo']    ?? '';
$nombre      = $gw['nombre']    ?? '';
$orden_id    = $gw['orden_id']  ?? '';
$message     = $gw['message']   ?? '';
$reference   = $gw['reference'] ?? '';

// Definir visual según estado
if ($status === 'APPROVED') {
    $icono   = '✅'; $titulo  = '¡Pago aprobado!';
    $mensaje = 'Tu compra fue procesada exitosamente. ¡Disfruta tu Cash!';
    $color   = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
} elseif ($status === 'PENDING') {
    $icono   = '⏳'; $titulo  = 'Pago pendiente';
    $mensaje = 'Tu pago está siendo procesado. Te notificaremos pronto.';
    $color   = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} else {
    $icono   = '❌'; $titulo  = 'Pago rechazado';
    $mensaje = !empty($message) ? $message : 'Tu pago no pudo ser procesado. Verifica los datos e intenta de nuevo.';
    $color   = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Cash Gateway</title>
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
            --ret-ctx-color: #fbbf24;
            --ret-ctx-rgb:   245, 158, 11;
        }
    </style>
</head>
<body>
    <div class="result-card" id="resultCard" data-tipo="orden" data-id="<?= (int) $orden_id ?>" data-pending="<?= $status === 'PENDING' ? '1' : '0' ?>">
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
            <i class="bi bi-cpu-fill"></i>
            Procesado via <strong>API Gateway</strong> · Evertec PlacetoPay
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
                <span>Total</span>
                <span style="color:<?= $color ?>; font-size:1.1rem;">
                    $<?= number_format((float)$precio, 0, ',', '.') ?> COP
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

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/games/juegos.php" class="btn-volver">Volver al comercio</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($status === 'PENDING'): ?>
    <script src="../assets/js/gw-resolver-poll.js"></script>
    <?php endif; ?>
</body>
</html>
