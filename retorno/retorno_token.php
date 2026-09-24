<?php
session_start();


require_once '../php/env.php';

$sub_id     = intval($_GET['sub'] ?? $_SESSION['token_sub_id'] ?? 0);
$request_id = $_SESSION['token_requestId'] ?? '';

if (!$sub_id || !$request_id) {
    header("Location: ../index.php");
    exit();
}

// ══════════════════════════════════════════
// Consultar resultado de tokenización
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
// Extraer token
// ══════════════════════════════════════════
$token      = '';
$status_p2p = $result['status']['status'] ?? 'UNKNOWN';

if (isset($result['subscription']['instrument']) && is_array($result['subscription']['instrument'])) {
    foreach ($result['subscription']['instrument'] as $item) {
        if (($item['keyword'] ?? '') === 'token') {
            $token = $item['value'] ?? '';
            break;
        }
    }
}

// ══════════════════════════════════════════
// Sin base de datos: no se persiste el token.
// ══════════════════════════════════════════
if (!empty($token)) {
    $exito   = true;
    $titulo  = '🔐 ¡Tarjeta guardada!';
    $mensaje = 'Tu tarjeta fue tokenizada exitosamente. Tu suscripción está completamente activada.';
    $color   = '#3ecf8e';
    $bg_icon = 'rgba(62,207,142,0.15)';
    $color_rgb = '62, 207, 142';
    $icono   = '✅';
} else {
    $exito   = false;
    $titulo  = 'No se pudo guardar';
    $mensaje = 'No logramos tokenizar tu tarjeta. Puedes intentarlo nuevamente desde tu historial.';
    $color   = '#e05252';
    $bg_icon = 'rgba(224,82,82,0.15)';
    $color_rgb = '224, 82, 82';
    $icono   = '❌';
}

// Limpiar sesión
unset($_SESSION['token_requestId'], $_SESSION['token_sub_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Tokenización</title>
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
            --ret-maxw:      420px;
        }
    </style>
</head>
<body>
    <div class="result-card">
        <div class="result-icon"><?= $icono ?></div>
        <div class="result-title"><?= $titulo ?></div>
        <p class="result-message"><?= $mensaje ?></p>

        <a href="../index.php" class="btn-home">← Inicio</a>
        <a href="../views/plataformas/streaming.php" class="btn-volver">Ver planes</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
