<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/plataformas/ia_gateway.php");
    exit();
}

require_once 'env.php';

// Recibir datos
$servicio     = trim($_POST['servicio']     ?? '');
$plan         = trim($_POST['plan']         ?? '');
$precio       = trim($_POST['precio']       ?? '');
$nombre       = trim($_POST['nombre']       ?? '');
$correo       = trim($_POST['correo']       ?? '');
$telefono     = trim($_POST['telefono']     ?? '');
$tipo_doc     = trim($_POST['tipo_doc']     ?? '');
$num_doc      = trim($_POST['num_doc']      ?? '');
$periodicidad = trim($_POST['periodicidad'] ?? 'M');

if (empty($servicio) || empty($plan) || empty($precio) || empty($nombre) || empty($correo) || empty($num_doc)) {
    die("❌ Faltan datos. Por favor completa todos los campos.");
}

// Sin base de datos: los valores ya vienen con trim (no hay SQL que escapar).
$periodicidad = ($periodicidad === 'Y') ? 'Y' : 'M';

// Calcular calendario según periodicidad (mismo criterio que crear_recurrencia.php / crear_suscription_rec.php)
if ($periodicidad === 'Y') {
    $next_payment = date('Y-m-d', strtotime('+1 year'));
    $fecha_fin    = date('Y-m-d', strtotime('+1 year'));
} else {
    $next_payment = date('Y-m-d', strtotime('+1 month'));
    $fecha_fin    = date('Y-m-d', strtotime('+12 months'));
}

// ══════════════════════════════════════════
// API Gateway Real — Recurrencia común
// Igual que crear_recurrencia.php en Web Checkout: se cobra el primer
// periodo YA y se le pasa a PlacetoPay el bloque "recurring" para que sea
// PlacetoPay quien programe y ejecute los cobros siguientes. No hay
// "subscribe" ni token: el comercio no gestiona el reintento, PlacetoPay sí.
// ══════════════════════════════════════════
require_once 'p2p_config.php';
require_once 'p2p_sonda_core.php';

$cred      = p2p_credenciales()['principal'];
$endpoint  = "https://api-test.placetopay.com/rest/gateway/process";
$auth      = p2p_construir_auth($cred['login'], $cred['secretKey']);
$reference = 'GWREC-' . strtoupper(bin2hex(random_bytes(4)));

if ($periodicidad === 'Y') {
    $interval   = "12";
    $maxPeriods = 1;
} else {
    $interval   = "1";
    $maxPeriods = 12;
}

$card_number = preg_replace('/\s/', '', $_POST['card_number'] ?? '');
$card_expiry = trim($_POST['card_expiry'] ?? '12/26');
$card_cvv    = trim($_POST['card_cvv']    ?? '');

$body = [
    "auth" => $auth,
    "payer" => [
        "name"         => $nombre,
        "surname"      => "",
        "email"        => $correo,
        "documentType" => $tipo_doc,
        "document"     => $num_doc,
        "mobile"       => $telefono
    ],
    "payment" => [
        "reference"   => $reference,
        "description" => $servicio . ' — ' . $plan,
        "amount"      => [
            "currency" => "COP",
            "total"    => (float) $precio
        ],
        // clave: PlacetoPay programa y ejecuta los cobros siguientes, no nosotros
        "recurring" => [
            "periodicity" => $periodicidad,
            "interval"    => $interval,
            "nextPayment" => $next_payment,
            "maxPeriods"  => $maxPeriods
        ]
    ],
    "instrument" => [
        "card" => [
            "number"     => $card_number,
            "expiration" => $card_expiry,
            "cvv"        => $card_cvv
        ]
    ],
    "ipAddress"       => $_SERVER['REMOTE_ADDR']     ?? '127.0.0.1',
    "userAgent"       => $_SERVER['HTTP_USER_AGENT'] ?? 'PlanceDemoAgent/1.0',
    "notificationUrl" => P2P_NOTIFY_URL
];

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST,           true);
curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($body));
curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT,        30);

$response = curl_exec($ch);
curl_close($ch);

$result     = json_decode($response, true);
$gw_reason  = $result['status']['reason']  ?? '';
$gw_message = $result['status']['message'] ?? 'Sin respuesta del servidor';

// ── Estado elegido por el usuario en estados-subs-gateway.php (demo) ──
$estado_elegido = trim($_POST['estado_elegido'] ?? '');
$razon_elegida  = trim($_POST['razon_elegida']  ?? $gw_reason);

// Estados "pendiente" con resolución diferida (demo): la transacción queda
// en 'pendiente' y, pasado `resuelve_en`, gw_resolver.php la resuelve a
// `resuelve_a` la próxima vez que la pantalla de resultado consulte su estado.
$resuelve_en = null;
$resuelve_a  = null;

if (in_array($estado_elegido, ['aprobada-token', 'aprobada-sin', 'pendiente', 'rechazada'])) {
    $nuevo_estado = match ($estado_elegido) {
        'aprobada-token', 'aprobada-sin' => 'aprobada',
        'pendiente' => 'pendiente',
        default     => 'rechazada'
    };
    $status = match ($nuevo_estado) {
        'aprobada'  => 'APPROVED',
        'pendiente' => 'PENDING',
        default     => 'REJECTED'
    };
} elseif (in_array($estado_elegido, ['pend-aprobada', 'pend-rechazada', 'pend-180min'])) {
    $nuevo_estado = 'pendiente';
    $status       = 'PENDING';
    $resuelve_a   = ($estado_elegido === 'pend-rechazada') ? 'rechazada' : 'aprobada';
    $resuelve_en  = ($estado_elegido === 'pend-180min')
        ? date('Y-m-d H:i:s', strtotime('+180 minutes'))
        : date('Y-m-d H:i:s', strtotime('+90 seconds'));
} else {
    $gw_status = $result['status']['status'] ?? 'FAILED';
    $nuevo_estado = match ($gw_status) {
        'APPROVED' => 'aprobada',
        'PENDING'  => 'pendiente',
        default    => 'rechazada'
    };
    $status = $gw_status;
}

// Sin base de datos: identificador local para el retorno
$gw_request_id = $result['internalReference'] ?? $reference;
$orden_id      = strtoupper(bin2hex(random_bytes(4)));

// Guardar en sesión para retorno
$_SESSION['gw_rec_result'] = [
    'orden_id'     => $orden_id,
    'status'       => $status,
    'estado'       => $nuevo_estado,
    'servicio'     => $servicio,
    'plan'         => $plan,
    'precio'       => $precio,
    'nombre'       => $nombre,
    'correo'       => $correo,
    'reference'    => $reference,
    'periodicidad' => $periodicidad,
    'next_payment' => $next_payment,
    'fecha_fin'    => $fecha_fin,
    'message'      => $gw_message,
    'resuelve_en'  => $resuelve_en,
    'resuelve_a'   => $resuelve_a,
];

unset($_SESSION['gw_subs_pending']);
header("Location: ../retorno/retorno_recurrencia_gateway.php?orden=" . $orden_id);
exit();
?>
