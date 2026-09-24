<?php
session_start();


$gw = $_SESSION['gw_rec_result'] ?? null;
unset($_SESSION['gw_rec_result']);

if (!$gw) {
    header("Location: ../index.php");
    exit();
}

$status       = $gw['status']       ?? 'FAILED';
$nuevo_estado = $gw['estado']       ?? 'rechazada';
$servicio     = $gw['servicio']     ?? '';
$plan         = $gw['plan']         ?? '';
$precio       = $gw['precio']       ?? 0;
$nombre       = $gw['nombre']       ?? '';
$correo       = $gw['correo']       ?? '';
$orden_id     = $gw['orden_id']     ?? '';
$reference    = $gw['reference']    ?? '';
$periodicidad = $gw['periodicidad'] ?? 'M';
$next_payment = $gw['next_payment'] ?? '';
$fecha_fin    = $gw['fecha_fin']    ?? '';
$message      = $gw['message']      ?? '';

if ($status === 'APPROVED') {
    $icono = '✅'; $titulo = '¡Recurrencia activada!';
    $mensaje = 'Se cobró el primer periodo y PlacetoPay programó los cobros siguientes automáticamente.';
    $color = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
} elseif ($status === 'PENDING') {
    $icono = '⏳'; $titulo = 'Proceso pendiente';
    $mensaje = 'Tu solicitud está siendo procesada.';
    $color = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} else {
    $icono = '❌'; $titulo = 'Recurrencia rechazada';
    $mensaje = !empty($message) ? $message : 'No se pudo procesar el primer cobro. Verifica los datos e intenta de nuevo.';
    $color = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Recurrencia IA's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700;800&display=swap" rel="stylesheet">
    <?php require_once dirname(__DIR__) . '/php/theme.php'; ?>
    <link rel="stylesheet" href="../assets/css/styles-retorno.css">
    <style>
        :root {
            --ret-color:     <?= $color ?>;
            --ret-bg-icon:   <?= $bg_icon ?>;
            --ret-color-rgb: <?= $color_rgb ?>;
            --ret-ctx-color: #f0b45f;
            --ret-ctx-rgb:   228, 111, 1;
        }
    </style>
</head>
<body>
    <div class="result-card" id="resultCard" data-tipo="recurrencia" data-id="<?= (int) $orden_id ?>" data-pending="<?= $status === 'PENDING' ? '1' : '0' ?>">
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
            <i class="bi bi-arrow-repeat"></i>
            Recurrencia · API Gateway · Evertec PlacetoPay
        </div>

        <?php if ($status === 'APPROVED' && !empty($next_payment)): ?>
        <div class="token-box">
            <i class="bi bi-arrow-repeat"></i>
            <span>🔄 <strong>Recurrencia activa</strong> — próximo cobro programado para <strong><?= htmlspecialchars($next_payment) ?></strong>.</span>
        </div>
        <?php endif; ?>

        <div class="order-details">
            <div class="order-row"><span>Orden #</span><span>#<?= htmlspecialchars($orden_id) ?></span></div>
            <div class="order-row"><span>Servicio</span><span><?= htmlspecialchars($servicio) ?></span></div>
            <div class="order-row"><span>Plan</span><span><?= htmlspecialchars($plan) ?></span></div>
            <div class="order-row"><span>Nombre</span><span><?= htmlspecialchars($nombre) ?></span></div>
            <div class="order-row"><span>Correo</span><span><?= htmlspecialchars($correo) ?></span></div>
            <div class="order-row"><span>Primer cobro</span><span style="color:<?= $color ?>;font-size:1.1rem;">$<?= number_format((float) $precio, 0, ',', '.') ?> COP</span></div>
            <div class="order-row"><span>Periodicidad</span><span><?= $periodicidad === 'Y' ? 'Anual' : 'Mensual' ?></span></div>
            <?php if (!empty($next_payment)): ?>
            <div class="order-row"><span>Próximo cobro</span><span><?= htmlspecialchars($next_payment) ?></span></div>
            <?php endif; ?>
            <?php if (!empty($fecha_fin)): ?>
            <div class="order-row"><span>Fin de la recurrencia</span><span><?= htmlspecialchars($fecha_fin) ?></span></div>
            <?php endif; ?>
            <?php if (!empty($reference)): ?>
            <div class="order-row"><span>Referencia</span><span style="font-size:0.78rem;color:var(--pt-text-sec);"><?= htmlspecialchars($reference) ?></span></div>
            <?php endif; ?>
            <div class="order-row"><span>Estado</span><span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span></div>
        </div>

        <div style="margin-top:1rem; padding:0.75rem 1rem; border:1px solid var(--pt-border); border-radius:8px; font-size:0.8rem; color:var(--pt-text-sec); text-align:left; display:flex; gap:0.5rem;">
            <i class="bi bi-info-circle-fill" style="flex-shrink:0;"></i>
            <span>El calendario de cobro (próximo cobro y fin) queda guardado en nuestra base de datos como referencia — es PlacetoPay quien ejecuta los cobros siguientes, no nuestro backend.</span>
        </div>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/plataformas/ia_gateway.php" class="btn-volver">Ver planes</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($status === 'PENDING'): ?>
    <script src="../assets/js/gw-resolver-poll.js"></script>
    <?php endif; ?>
</body>
</html>
