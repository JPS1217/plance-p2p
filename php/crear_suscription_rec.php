<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/plataformas/ia.php");
    exit();
}

require_once 'env.php';

$servicio     = trim($_POST['servicio']     ?? '');
$plan         = trim($_POST['plan']         ?? '');
$precio       = trim($_POST['precio']       ?? '');
$usuario_id   = trim($_POST['usuario_id']   ?? '');
$periodicidad = trim($_POST['periodicidad'] ?? 'M');

if (empty($servicio) || empty($plan) || empty($precio) || empty($usuario_id)) {
    die("❌ Faltan datos.");
}

// Sin base de datos: los valores ya vienen con trim (no hay SQL que escapar).

// Calcular fechas según periodicidad
if ($periodicidad === 'Y') {
    $next_payment = date('Y-m-d', strtotime('+1 year'));
    $fecha_fin    = date('Y-m-d', strtotime('+1 year'));
    $maxPeriods   = 1;
    $interval     = "12";
} else {
    $next_payment = date('Y-m-d', strtotime('+1 month'));
    $fecha_fin    = date('Y-m-d', strtotime('+12 months'));
    $maxPeriods   = 12;
    $interval     = "1";
}

// Sin base de datos: identificador local para la referencia del pago
$rec_id = strtoupper(bin2hex(random_bytes(4)));

// ══════════════════════════════════════════
// WEB CHECKOUT — Pago recurrente
// ══════════════════════════════════════════
$login     = "2d9eaf1e662518756a3d78806543af5b";
$secretKey = "3YC5brb5eAR4xBGQ";
$url       = "https://checkout-test.placetopay.com/api/session";

$seed     = date('c');
$nonce    = bin2hex(random_bytes(16));
$tranKey  = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));
$nonceB64 = base64_encode($nonce);

$descripcion = substr(preg_replace('/[^a-zA-Z0-9 ]/u', '', $servicio . ' ' . $plan), 0, 80);

$data = [
    "locale" => "es_CO",
    "auth"   => [
        "login"   => $login,
        "tranKey" => $tranKey,
        "nonce"   => $nonceB64,
        "seed"    => $seed
    ],
    "buyer" => ["email" => $usuario_id],
    "payment" => [
        "reference"   => "SREC-" . (string)$rec_id,
        "description" => $descripcion,
        "amount"      => [
            "currency" => "COP",
            "total"    => (float)$precio
        ],
        "recurring" => [
            "periodicity" => $periodicidad,
            "interval"    => $interval,
            "nextPayment" => $next_payment,
            "maxPeriods"  => $maxPeriods
        ]
    ],
    "expiration" => date('c', strtotime('+1 hour')),
    "returnUrl"  => app_base_url() . "/retorno/retorno_suscription_rec.php?rec=" . $rec_id,
    "notifyUrl"  => "https://doorman-situated-delivery.ngrok-free.dev/plance/php/notify.php",
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

if (!$response) die("❌ Error de conexión: " . $curlError);

$result = json_decode($response, true);

if (isset($result['processUrl'])) {
    $_SESSION['srec_requestId'] = $result['requestId'] ?? '';
    $_SESSION['srec_info'] = [
        'id'           => $rec_id,
        'servicio'     => $servicio,
        'plan'         => $plan,
        'precio'       => $precio,
        'usuario_id'   => $usuario_id,
        'periodicidad' => $periodicidad,
        'next_payment' => $next_payment,
        'fecha_fin'    => $fecha_fin,
    ];
    header("Location: " . $result['processUrl']);
    exit();
} else {
    echo "<h3 style='font-family:sans-serif;color:#e05252;'>❌ Error al crear sesión</h3>";
    echo "<pre style='background:#1e2128;color:#f0f1f3;padding:1rem;border-radius:8px;'>";
    print_r($result);
    echo "</pre>";
    echo "<a href='../views/plataformas/ia.php' style='color:#8b5cf6;'>← Volver</a>";
}
?>