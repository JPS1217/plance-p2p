<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/reservaciones/hotel.php");
    exit();
}

require_once 'env.php';

// Recibir datos
$habitacion = trim($_POST['habitacion'] ?? '');
$precio     = (float)($_POST['precio']  ?? 0);
$total      = (float)($_POST['total']   ?? 0);
$noches     = (int)($_POST['noches']    ?? 1);
$checkin    = trim($_POST['checkin']    ?? '');
$checkout   = trim($_POST['checkout']   ?? '');
$nombre     = trim($_POST['nombre']     ?? '');
$correo     = trim($_POST['correo']     ?? '');
$telefono   = trim($_POST['telefono']   ?? '');
$tipo_doc   = trim($_POST['tipo_doc']   ?? '');
$num_doc    = trim($_POST['num_doc']    ?? '');

if (empty($habitacion) || $total <= 0 || empty($checkin) || empty($checkout) || empty($nombre) || empty($correo)) {
    die("❌ Faltan datos. Por favor completa todos los campos.");
}

// ── Auth ──
$login     = "62f3eeeb7655485cbf65b306b4585dfd";
$secretKey = "K8zGmmoark19y2ey";
$endpoint  = "https://checkout-test.placetopay.com/api/session";

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$reference = 'PRE-' . strtoupper(bin2hex(random_bytes(4)));

// ── Body con type: checkin ──
$body = [
    "locale" => "es_CO",
    "auth"   => [
        "login"   => $login,
        "tranKey" => $tranKey,
        "nonce"   => $nonceB64,
        "seed"    => $seed
    ],
    "type" => "checkin",
    "payment" => [
        "reference"   => $reference,
        "description" => "Reserva " . $habitacion . " - " . $noches . " noches",
        "amount"      => [
            "currency" => "COP",
            "total"    => $total
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
    "expiration" => date('c', strtotime('+2 days')),
    "returnUrl"  => app_base_url() . "/retorno/retorno_preautorizacion.php?reserva_id=RESERVA_ID_PLACEHOLDER",
    "ipAddress"  => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
    "userAgent"  => $_SERVER['HTTP_USER_AGENT'] ?? 'PlanceDemoAgent/1.0',
    "notificationUrl" => "https://doorman-situated-delivery.ngrok-free.dev/plance/php/notify.php"
];

// ── Sin base de datos: identificador local para el retorno ──
$reserva_id = strtoupper(bin2hex(random_bytes(4)));

// ── Reemplazar el placeholder con el reserva_id ──
$body['returnUrl'] = app_base_url() . "/retorno/retorno_preautorizacion.php?reserva_id={$reserva_id}";

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
$message    = $result['status']['message'] ?? 'Sin respuesta';
$requestId  = $result['requestId']         ?? null;
$processUrl = $result['processUrl']        ?? null;

// Sin base de datos: no se persiste el requestId.

// ── Guardar en sesión para retorno ──
$_SESSION['pre_result'] = [
    'reserva_id' => $reserva_id,
    'habitacion' => $habitacion,
    'total'      => $total,
    'noches'     => $noches,
    'checkin'    => $checkin,
    'checkout'   => $checkout,
    'nombre'     => $nombre,
    'correo'     => $correo,
    'reference'  => $reference,
    'requestId'  => $requestId,
    'processUrl' => $processUrl,
    'status'     => $status,
];

// ── Redirigir a PlacetoPay si fue OK ──
if ($status === 'OK' && $processUrl) {
    header("Location: " . $processUrl);
    exit();
}

header("Location: ../retorno/retorno_preautorizacion.php?error=1");
exit();
?>