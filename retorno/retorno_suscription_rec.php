<?php
session_start();


require_once '../php/env.php';

$rec_id = intval($_GET['rec'] ?? 0);
if (!$rec_id) { header("Location: ../index.php"); exit(); }

// Sin base de datos: request_id e info los dejó crear_suscription_rec en sesión
$row        = $_SESSION['srec_info'] ?? null;
$request_id = $_SESSION['srec_requestId'] ?? '';

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

if ($status_p2p === 'APPROVED') {
    $nuevo_estado = 'aprobada';
    $icono = '✅'; $titulo = '¡Recurrencia IA activada!';
    $mensaje = 'Tu plan de IA fue activado. Los cobros se realizarán automáticamente.';
    $color = '#3ecf8e'; $bg_icon = 'rgba(62,207,142,0.15)'; $color_rgb = '62, 207, 142';
} elseif ($status_p2p === 'REJECTED') {
    $nuevo_estado = 'rechazada';
    $icono = '❌'; $titulo = 'Pago rechazado';
    $mensaje = 'Tu pago no pudo ser procesado. Intenta de nuevo.';
    $color = '#e05252'; $bg_icon = 'rgba(224,82,82,0.15)'; $color_rgb = '224, 82, 82';
} elseif ($status_p2p === 'PENDING') {
    $nuevo_estado = 'pendiente';
    $icono = '⏳'; $titulo = 'Pago pendiente';
    $mensaje = 'Tu pago está siendo procesado. Te notificaremos pronto.';
    $color = '#f0b429'; $bg_icon = 'rgba(240,180,41,0.15)'; $color_rgb = '240, 180, 41';
} else {
    $nuevo_estado = 'cancelada';
    $icono = '🚫'; $titulo = 'Recurrencia cancelada';
    $mensaje = 'Cancelaste el proceso de pago.';
    $color = '#8a8d96'; $bg_icon = 'rgba(138,141,150,0.15)'; $color_rgb = '138, 141, 150';
}

// Sin base de datos: no se persiste el estado.

$rec = $row;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Plan IA</title>
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
            --ret-ctx-color: #ffa45a;
            --ret-ctx-rgb:   246, 184, 92;
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

        <?php if ($rec): ?>
        <div class="order-details">
            <div class="order-row"><span>Recurrencia #</span><span>#<?= htmlspecialchars($rec['id']) ?></span></div>
            <div class="order-row"><span>Servicio</span><span><?= htmlspecialchars($rec['servicio']) ?></span></div>
            <div class="order-row"><span>Plan</span><span><?= htmlspecialchars($rec['plan']) ?></span></div>
            <div class="order-row"><span>Correo</span><span><?= htmlspecialchars($rec['usuario_id']) ?></span></div>
            <div class="order-row"><span>Total</span><span>$<?= number_format($rec['precio'], 0, ',', '.') ?> COP</span></div>
            <div class="order-row"><span>Periodicidad</span><span><?= $rec['periodicidad'] === 'Y' ? 'Anual' : 'Mensual' ?></span></div>
            <div class="order-row"><span>Próximo cobro</span><span><?= htmlspecialchars($rec['next_payment'] ?? 'N/A') ?></span></div>
            <div class="order-row"><span>Fin</span><span style="color:#8b5cf6;"><?= $nuevo_estado === 'aprobada' ? date('Y-m-d', $rec['periodicidad'] === 'Y' ? strtotime('+1 year') : strtotime('+12 months')) : 'N/A' ?></span></div>
            <div class="order-row"><span>Estado</span><span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span></div>
        </div>

        <?php if ($nuevo_estado === 'aprobada'): ?>
        <div class="recurring-detail">
            <i class="bi bi-arrow-repeat"></i>
            <span>Tu plan se renovará automáticamente de forma <strong><?= $rec['periodicidad'] === 'Y' ? 'anual' : 'mensual' ?></strong>. Próximo cobro: <strong><?= htmlspecialchars($rec['next_payment'] ?? 'N/A') ?></strong></span>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/plataformas/ia.php" class="btn-volver">Ver planes</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
