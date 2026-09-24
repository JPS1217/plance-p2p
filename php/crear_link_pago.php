<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/textil/pl.php");
    exit();
}

require_once 'p2p_config.php';
require_once 'env.php';

// Recibir datos
$producto = trim($_POST['producto'] ?? '');
$precio   = trim($_POST['precio']   ?? '');
$correo   = trim($_POST['correo']   ?? '');
$nombre   = trim($_POST['nombre']   ?? '');

if (empty($producto) || empty($precio) || empty($correo)) {
    die("❌ Faltan datos.");
}

// Sin base de datos: los valores ya vienen con trim (no hay SQL que escapar).

// Generar referencia única
$referencia  = 'PL-' . strtoupper(bin2hex(random_bytes(4)));
$descripcion = 'Kit deportivo: ' . $producto;
$expiracion  = date('Y-m-d H:i:s', strtotime('+24 hours'));

// ══════════════════════════════════════════
// 🔗 LINK DE PAGO — PlacetoPay
// ══════════════════════════════════════════
$creds     = p2p_credenciales()['principal'];
$login     = $creds['login'];
$secretKey = $creds['secretKey'];
$url       = "https://sites-test.placetopay.com/api/payment-link";

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$data = [
    "auth" => [
        "login"   => $login,
        "tranKey" => $tranKey,
        "nonce"   => $nonceB64,
        "seed"    => $seed
    ],
    "locale"            => "es_CO",
    "name"              => $producto,
    "description"       => $descripcion,
    "reference"         => $referencia,
    "paymentsAllowed"   => 12,
    "expirationDate"    => $expiracion,
    "paymentExpiration" => 15,  
    "payment" => [
        "amount" => [
            "currency" => "COP",
            "total"    => (float)$precio
        ]
    ],
    "paymentMethod"  => ["pse", "visa", "mastercard"],
    "notificationUrl" => "https://doorman-situated-delivery.ngrok-free.dev/plance/php/notify.php",
    "receiverEmails" => [$correo]
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
$httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result   = json_decode($response, true);
$link_url = $result['url']  ?? $result['link'] ?? $result['data']['url'] ?? '';
$link_id  = $result['id']   ?? $result['linkId'] ?? '';
$status   = $result['status']['status'] ?? ($link_url ? 'OK' : 'ERROR');

// Sin base de datos: identificador local para el retorno
$registro_id = strtoupper(bin2hex(random_bytes(4)));

// Guardar en sesión para retorno
$_SESSION['link_result'] = [
    'registro_id' => $registro_id,
    'producto'    => $producto,
    'precio'      => $precio,
    'correo'      => $correo,
    'nombre'      => $nombre,
    'referencia'  => $referencia,
    'link_url'    => $link_url,
    'link_id'     => $link_id,
    'expiracion'  => $expiracion,
    'status'      => $status,
    'http_code'   => $httpCode,
    'raw'         => $result
];

header("Location: ../retorno/retorno_link.php");
exit();
?>