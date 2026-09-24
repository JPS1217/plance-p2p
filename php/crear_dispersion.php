<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/dispersiones/tickets.php");
    exit();
}

require_once 'env.php';

// Recibir datos
$destino   = trim($_POST['destino']   ?? '');
$base      = (float)($_POST['base']   ?? 0);
$impuesto  = (float)($_POST['impuesto'] ?? 0);
$total     = (float)($_POST['total']  ?? 0);
$nombre    = trim($_POST['nombre']    ?? '');
$correo    = trim($_POST['correo']    ?? '');
$telefono  = trim($_POST['telefono']  ?? '');
$tipo_doc  = trim($_POST['tipo_doc']  ?? '');
$num_doc   = trim($_POST['num_doc']   ?? '');

if (empty($destino) || $total <= 0 || empty($nombre) || empty($correo)) {
    die("❌ Faltan datos principales.");
}

// ── Auth ──
$login     = "8ddd7ab3d5a270608832d033849a1a8d";
$secretKey = "U7rCf9me0vqk7755";
$endpoint  = "https://checkout-test.placetopay.com/api/session";

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$reference = 'DISP-' . strtoupper(bin2hex(random_bytes(4)));

// ── Sin base de datos: identificador local para el retorno ──
$dispersion_id = strtoupper(bin2hex(random_bytes(4)));

// ── Body con dispersión ──
$body = [
    "auth" => [
        "login"   => $login,
        "tranKey" => $tranKey,
        "nonce"   => $nonceB64,
        "seed"    => $seed
    ],
    "payment" => [
        "reference"   => $reference,
        "description" => "Tiquete a " . $destino,
        "amount"      => [
            "currency" => "COP",
            "total"    => $total
        ],
        "dispersion" => [
            [
                "agreement"     => 1,
                "agreementType" => "AIRLINE",
                "amount"        => [
                    "currency" => "COP",
                    "total"    => $base
                ]
            ],
            [
                "agreement"     => 2,
                "agreementType" => "MERCHANT",
                "amount"        => [
                    "currency" => "COP",
                    "total"    => $impuesto
                ]
            ]
        ]
    ],
    "buyer" => [
        "name"         => $nombre,
        "surname"      => "",
        "email"        => $correo,
        "documentType" => $tipo_doc,
        "document"     => $num_doc,
        "mobile"       => $telefono
    ],
    "expiration" => date('c', strtotime('+30 minutes')),
    "returnUrl"  => app_base_url() . "/retorno/retorno_dispersion.php?disp_id={$dispersion_id}",
    "ipAddress"  => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
    "userAgent"  => $_SERVER['HTTP_USER_AGENT'] ?? 'PlanceDemoAgent/1.0',
    "locale"     => "es_CO"
];

// ── Llamada cURL ──
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST,           true);
curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($body));
curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT,        30);

$response  = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    die("❌ Error de conexión: " . $curlError);
}

$result     = json_decode($response, true);
$status     = $result['status']['status']  ?? 'FAILED';
$processUrl = $result['processUrl']        ?? null;
$requestId  = $result['requestId']         ?? null;

// Sin base de datos: no se persiste el requestId.

// Datos para la pantalla de retorno (sin BD)
$_SESSION['disp_result'] = [
    'disp_id'      => $dispersion_id,
    'destino'      => $destino,
    'precio_total' => $total,
    'precio_base'  => $base,
    'impuesto'     => $impuesto,
    'request_id'   => $requestId ?? $reference,
];

// Redirigir al WC si fue OK
if ($status === 'OK' && $processUrl) {
    header("Location: " . $processUrl);
    exit();
}

header("Location: ../retorno/retorno_dispersion.php?disp_id={$dispersion_id}&error=1");
exit();
?>
