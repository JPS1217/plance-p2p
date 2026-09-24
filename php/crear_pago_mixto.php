
<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/games/rainbowsix.php");
    exit();
}

require_once 'env.php';

// Recibir datos
$jugador_id    = trim($_POST['jugador_id']    ?? '');
$productos     = trim($_POST['productos']     ?? '');
$total         = (float)($_POST['total']      ?? 0);
$monto_parcial = (float)($_POST['monto_parcial'] ?? $total);
$allow_partial = ($_POST['allow_partial']     ?? '0') === '1';
$items_json    = $_POST['items_json']         ?? '[]';

if (empty($jugador_id) || empty($productos) || $total <= 0) {
    die("❌ Faltan datos principales.");
}

// Sin base de datos: los valores ya vienen con trim (no hay SQL que escapar).

// ── Credenciales y Auth ──
$login     = "2d9eaf1e662518756a3d78806543af5b";
$secretKey = "3YC5brb5eAR4xBGQ";
$endpoint  = "https://checkout-test.placetopay.com/api/session";

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$reference = 'MIX-' . strtoupper(bin2hex(random_bytes(4)));

// ── Body del request ──
// Para pagos mixtos: SIEMPRE enviar el total completo en amount.total
// PlacetoPay mostrará la casilla para que el usuario elija cuánto pagar
$amount_config = [
    "currency" => "COP",
    "total"    => (float)$total  // Siempre el total completo
];

// Si es pago parcial, agregar monto mínimo (10% del total)
if ($allow_partial) {
    $amount_config["minimum"] = (float)ceil($total * 0.1);
}

$body = [
    "auth" => [
        "login"   => $login,
        "tranKey" => $tranKey,
        "nonce"   => $nonceB64,
        "seed"    => $seed
    ],
    "payment" => [
        "reference"    => $reference,
        "description"  => $productos,
        "amount"       => $amount_config,
        "allowPartial" => $allow_partial
    ],
    "expiration"      => date('c', strtotime('+30 minutes')),
    "returnUrl"       => app_base_url() . "/retorno/retorno_mixto.php",
    "ipAddress"       => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
    "userAgent"       => $_SERVER['HTTP_USER_AGENT'] ?? 'PlanceDemoAgent/1.0',
    "locale"          => "es_CO"
];

// ── Llamada a PlacetoPay ──
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
$reason     = $result['status']['reason']  ?? '';
$message    = $result['status']['message'] ?? 'Sin respuesta';
$requestId  = $result['requestId']         ?? null;
$processUrl = $result['processUrl']        ?? null;

// Sin base de datos: identificador local para el retorno
$estado_db = ($status === 'OK') ? 'pendiente' : 'rechazada';
$orden_id  = strtoupper(bin2hex(random_bytes(4)));

// ── Sesión para retorno ──
$_SESSION['mix_result'] = [
    'orden_id'      => $orden_id,
    'productos'     => $productos,
    'total'         => $total,
    'monto_parcial' => $monto_parcial,
    'allow_partial' => $allow_partial,
    'reference'     => $reference,
    'requestId'     => $requestId,
    'processUrl'    => $processUrl,
    'status'        => $status,
    'message'       => $message,
];

// Si todo bien → redirigir a PlacetoPay
if ($status === 'OK' && $processUrl) {
    header("Location: " . $processUrl);
    exit();
}

// Si falló → retorno con error
header("Location: ../retorno/retorno_mixto.php?error=1");
exit();
?>