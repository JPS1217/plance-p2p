<?php
session_start();


require_once '../php/env.php';

$disp_id = $_GET['disp_id'] ?? '';
if (!$disp_id) { header("Location: ../index.php"); exit(); }

// Sin base de datos: datos y requestId los dejó crear_dispersion en sesión
$row = $_SESSION['disp_result'] ?? null;
if (!$row) { header("Location: ../index.php"); exit(); }

$destino   = $row['destino'];
$total     = (float)$row['precio_total'];
$base      = (float)$row['precio_base'];
$impuesto  = (float)$row['impuesto'];
$requestId = $row['request_id'];

// Consultar estado real en PlacetoPay
$nuevo_estado = 'pendiente';
$gw_status    = 'PENDING';

if ($requestId) {
    $login     = "8ddd7ab3d5a270608832d033849a1a8d";
    $secretKey = "U7rCf9me0vqk7755";
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

    if (!empty($data['payment'])) {
        $gw_status = $data['payment'][0]['status']['status'] ?? $gw_status;
    }

    $nuevo_estado = match($gw_status) {
        'APPROVED' => 'aprobada',
        'PENDING'  => 'pendiente',
        default    => 'rechazada'
    };

    // Sin base de datos: no se persiste el estado.
}

// Colores
if ($gw_status === 'APPROVED') {
    $icono = '✅'; $titulo = '¡Tiquete confirmado!';
    $mensaje = 'Tu pago fue procesado y dispersado exitosamente entre la aerolínea y los impuestos aeroportuarios.';
    $color = '#10b981'; $bg_icon = 'rgba(16,185,129,0.15)'; $color_rgb = '16, 185, 129';
} elseif ($gw_status === 'PENDING') {
    $icono = '⏳'; $titulo = 'Pago pendiente';
    $mensaje = 'Tu pago está siendo procesado. Te notificaremos cuando se confirme.';
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
    <title>Resultado — Tiquete</title>
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
            --ret-ctx-color: #6ee7b7;
            --ret-ctx-rgb:   16, 185, 129;
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

        <div class="disp-badge">
            <i class="bi bi-diagram-3-fill"></i>
            Dispersión de pago · Web Checkout · PlacetoPay
        </div>

        <?php if ($gw_status === 'APPROVED'): ?>
        <!-- Desglose dispersión -->
        <div class="disp-box">
            <div class="disp-title">💸 Distribución del pago</div>
            <div class="disp-row">
                <span>✈️ Aerolínea (vuelo)</span>
                <span style="color:#10b981;font-weight:700;">$<?= number_format($base, 0, ',', '.') ?> COP</span>
            </div>
            <div class="disp-row">
                <span>🏛️ Impuestos aeroportuarios</span>
                <span style="color:#f0b429;font-weight:700;">$<?= number_format($impuesto, 0, ',', '.') ?> COP</span>
            </div>
            <div class="disp-row total">
                <span>Total dispersado</span>
                <span>$<?= number_format($total, 0, ',', '.') ?> COP</span>
            </div>
        </div>
        <?php endif; ?>

        <div class="order-details">
            <div class="order-row"><span>Tiquete #</span><span>#<?= $disp_id ?></span></div>
            <div class="order-row"><span>Destino</span><span>✈️ <?= htmlspecialchars($destino) ?></span></div>
            <div class="order-row"><span>Total</span><span style="color:<?= $color ?>;font-size:1.05rem;">$<?= number_format($total, 0, ',', '.') ?> COP</span></div>
            <div class="order-row"><span>Referencia</span><span style="font-size:0.78rem;color:var(--pt-text-sec);"><?= htmlspecialchars($row['request_id']) ?></span></div>
            <div class="order-row">
                <span>Estado</span>
                <span><span class="estado-badge"><?= strtoupper($nuevo_estado) ?></span></span>
            </div>
        </div>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/dispersiones/tickets.php" class="btn-volver">Ver tiquetes</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
