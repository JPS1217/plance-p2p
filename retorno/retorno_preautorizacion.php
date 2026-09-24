<?php
session_start();


require_once '../php/env.php';

$pre = $_SESSION['pre_result'] ?? null;

// Leer reserva_id desde GET (viene del returnUrl) o desde sesión
$reserva_id = $_GET['reserva_id'] ?? ($pre['reserva_id'] ?? '');

if (!$reserva_id || !$pre) {
    header("Location: ../index.php");
    exit();
}

// Sin base de datos: todos los datos vienen de la sesión que dejó crear_preautorizacion
$habitacion = $pre['habitacion'] ?? '';
$total      = (float)($pre['total'] ?? 0);
$correo     = $pre['correo'] ?? '';
$reference  = $pre['reference'] ?? '';   // referencia PRE-XXXX
$requestId  = $pre['requestId'] ?? '';   // requestId numérico de PlacetoPay
$checkin    = $pre['checkin'] ?? '';
$checkout   = $pre['checkout'] ?? '';
$noches     = (int)($pre['noches'] ?? 1);
$nombre     = $pre['nombre'] ?? '';

unset($_SESSION['pre_result']);

// Consultar estado real en PlacetoPay
$nuevo_estado = 'pendiente';
$gw_status    = 'PENDING';
$gw_reason    = '';

if ($requestId) {
    $login     = "62f3eeeb7655485cbf65b306b4585dfd";
    $secretKey = "K8zGmmoark19y2ey";
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

    $data      = json_decode($resp, true);
    $gw_status = $data['status']['status'] ?? 'PENDING';
    $gw_reason = $data['status']['reason'] ?? '';

    if (!empty($data['payment'])) {
        $gw_status = $data['payment'][0]['status']['status'] ?? $gw_status;
        $gw_reason = $data['payment'][0]['status']['reason'] ?? $gw_reason;
    }

    $nuevo_estado = match($gw_status) {
        'APPROVED' => 'aprobada',
        'PENDING'  => 'pendiente',
        default    => 'rechazada'
    };

    // Sin base de datos: no se persiste el estado.
}

// Colores y textos según estado
if ($gw_status === 'APPROVED') {
    $icono   = '🏨'; $titulo  = '¡Reserva confirmada!';
    $mensaje = 'Tu habitación ha sido reservada exitosamente. La preautorización fue aprobada — tu tarjeta no ha sido cobrada aún.';
    $color   = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
} elseif ($gw_status === 'PENDING') {
    $icono   = '⏳'; $titulo  = 'Reserva pendiente';
    $mensaje = 'Tu reserva está siendo procesada. Te notificaremos cuando se confirme la preautorización.';
    $color   = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} elseif ($gw_reason === 'EX') {
    $icono   = '⏱️'; $titulo  = 'Sesión expirada';
    $mensaje = 'El tiempo para completar la preautorización se agotó y la sesión de pago venció. Tu tarjeta no fue afectada. Vuelve a intentar la reserva.';
    $color   = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} elseif ($gw_reason === '¬C') {
    $icono   = '✋'; $titulo  = 'Pago cancelado';
    $mensaje = 'Cancelaste el proceso de preautorización antes de completarlo. Tu tarjeta no fue afectada. Puedes volver a intentar la reserva cuando quieras.';
    $color   = '#8a8d96'; $bg_icon = 'rgba(138,141,150,0.15)'; $color_rgb = '138, 141, 150';
} else {
    $icono   = '❌'; $titulo  = 'Reserva rechazada';
    $mensaje = 'No se pudo procesar la preautorización. Por favor intenta con otra tarjeta o contacta a tu banco.';
    $color   = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Preautorización</title>
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
            --ret-ctx-color: #a5b4fc;
            --ret-ctx-rgb:   99, 102, 241;
        }
    </style>
</head>
<body>
    <div class="result-card">
        <?php if ($gw_status === 'PENDING'): ?>
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

        <div class="pre-badge">
            <i class="bi bi-shield-lock-fill"></i>
            Preautorización (Check-in) · Web Checkout · PlacetoPay
        </div>

        <?php if ($gw_status === 'APPROVED'): ?>
        <!-- Fechas de estadía -->
        <div class="stay-box">
            <div class="stay-item">
                <div class="stay-label">Check-in</div>
                <div class="stay-date"><?= htmlspecialchars($checkin) ?></div>
            </div>
            <div class="stay-sep">→</div>
            <div class="stay-item">
                <div class="stay-label">Check-out</div>
                <div class="stay-date"><?= htmlspecialchars($checkout) ?></div>
            </div>
            <div class="stay-sep">·</div>
            <div class="stay-item">
                <div class="stay-label">Noches</div>
                <div class="stay-date"><?= $noches ?></div>
            </div>
        </div>

        <div class="preauth-aviso">
            ⚠️ <strong>Recuerda:</strong> Esta es una <strong>preautorización</strong> — tu tarjeta no ha sido cobrada. El cargo se realizará al momento del check-out en el hotel.
        </div>
        <?php endif; ?>

        <div class="order-details">
            <div class="order-row"><span>Reserva #</span><span>#<?= $reserva_id ?></span></div>
            <div class="order-row"><span>Habitación</span><span><?= htmlspecialchars($habitacion) ?></span></div>
            <div class="order-row"><span>Huésped</span><span><?= htmlspecialchars($nombre) ?></span></div>
            <div class="order-row"><span>Correo</span><span><?= htmlspecialchars($correo) ?></span></div>
            <div class="order-row">
                <span>Monto preautorizado</span>
                <span style="color:<?= $color ?>;font-size:1.05rem;">$<?= number_format($total, 0, ',', '.') ?> COP</span>
            </div>
            <div class="order-row"><span>Referencia</span><span style="font-size:0.78rem;color:var(--pt-text-sec);"><?= htmlspecialchars($reference) ?></span></div>
            <div class="order-row">
                <span>Estado</span>
                <span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span>
            </div>
        </div>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/reservaciones/hotel.php" class="btn-volver">Ver habitaciones</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
