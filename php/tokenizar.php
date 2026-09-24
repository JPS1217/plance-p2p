<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

require_once 'env.php';

$sub_id = intval($_GET['sub'] ?? 0);
if (!$sub_id) {
    header("Location: ../index.php");
    exit();
}

// Sin base de datos: los datos de la suscripción los dejó crear_subs en sesión
$subs = $_SESSION['sub_info'] ?? null;

if (!$subs) {
    header("Location: ../index.php");
    exit();
}

// ══════════════════════════════════════════
// 🔐 Crear sesión de SOLO tokenización
// subscription puro — NO cobra nada
// ══════════════════════════════════════════
$login     = "2d9eaf1e662518756a3d78806543af5b";
$secretKey = "3YC5brb5eAR4xBGQ";
$url       = "https://checkout-test.placetopay.com/api/session";

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$data = [
    "locale" => "es_CO",
    "auth"   => [
        "login"   => $login,
        "tranKey" => $tranKey,
        "nonce"   => $nonceB64,
        "seed"    => $seed
    ],
    "buyer" => [
        "email" => $subs['usuario_id']
    ],
    // subscription puro — solo tokeniza, NO cobra
    "subscription" => [
        "reference"   => "TOKEN-SUB-" . $sub_id,
        "description" => "Guardar tarjeta para " . $subs['plataforma'] . " " . $subs['plan']
    ],
    "expiration" => date('c', strtotime('+30 minutes')),
    "returnUrl"  => app_base_url() . "/retorno/retorno_token.php?sub=" . $sub_id,
    "ipAddress"  => $_SERVER['REMOTE_ADDR'],
    "userAgent"  => $_SERVER['HTTP_USER_AGENT']
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST,           true);
curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response  = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if (!$response) {
    die("❌ Error de conexión con PlaceToPay: " . $curlError);
}

$result = json_decode($response, true);

if (isset($result['processUrl'])) {
    // Guardar requestId de tokenización en sesión
    $_SESSION['token_requestId'] = $result['requestId'] ?? '';
    $_SESSION['token_sub_id']    = $sub_id;
    header("Location: " . $result['processUrl']);
    exit();
} else {
    echo "<h3 style='font-family:sans-serif;color:#e05252;'>❌ Error al crear sesión de tokenización</h3>";
    echo "<pre style='background:#1e2128;color:#f0f1f3;padding:1rem;border-radius:8px;font-size:0.85rem;'>";
    print_r($result);
    echo "</pre>";
    echo "<a href='../views/plataformas/streaming.php' style='color:#a855f7;font-family:sans-serif;'>← Volver</a>";
}
?>