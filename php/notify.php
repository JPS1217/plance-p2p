<?php
// notify.php - Endpoint para recibir notificaciones (webhooks) de PlaceToPay
// Docs: https://docs.placetopay.dev/checkout/notification
//       https://docs.placetopay.dev/gateway/webhooks/

require_once 'p2p_config.php';

// Log de todo lo que llega (metodo y body) para depurar
$raw_body = file_get_contents('php://input');
file_put_contents(
    __DIR__ . '/notify_debug.log',
    date('Y-m-d H:i:s') . ' | ' . $_SERVER['REQUEST_METHOD'] . ' | ' . ($_SERVER['REMOTE_ADDR'] ?? '?') . "\n" . $raw_body . "\n\n",
    FILE_APPEND
);

// Responder siempre JSON
header('Content-Type: application/json');

// GET/HEAD: health-check (evita el 405 al abrir la URL en navegador o pings de validacion)
if (in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD'], true)) {
    http_response_code(200);
    echo json_encode(['status' => 'OK', 'message' => 'Endpoint de notificaciones activo']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'ERROR', 'message' => 'Metodo no permitido']);
    exit();
}

$data = json_decode($raw_body, true);
if (empty($data) || !is_array($data)) {
    http_response_code(400);
    echo json_encode(['status' => 'ERROR', 'message' => 'Sin datos']);
    exit();
}

// Sin base de datos: el webhook valida la firma y registra la notificación,
// pero ya no persiste estado (no hay tablas que actualizar).

// ==============================================================
// Webhook de devoluciones ACH (chargeback.created)
// Firma: header X-Signature = HMAC-SHA256(body, tranKey)
// ==============================================================
if (($data['type'] ?? '') === 'chargeback.created') {
    $headers  = function_exists('getallheaders') ? getallheaders() : [];
    $recibida = $headers['X-Signature'] ?? $headers['x-signature'] ?? '';

    $valida = false;
    foreach (P2P_CREDENCIALES as $cred) {
        if (hash_equals(hash_hmac('sha256', $raw_body, $cred['secretKey']), (string)$recibida)) {
            $valida = true;
            break;
        }
    }

    if (!$valida) {
        http_response_code(403);
        echo json_encode(['status' => 'ERROR', 'message' => 'Firma invalida']);
        exit();
    }

    // Por ahora solo se registra el chargeback en el log
    file_put_contents(__DIR__ . '/notify_debug.log', date('Y-m-d H:i:s') . " | CHARGEBACK registrado\n\n", FILE_APPEND);
    http_response_code(200);
    echo json_encode(['status' => 'OK']);
    exit();
}

// ==============================================================
// Notificacion de Checkout / recurrencias
// Body: { status: {status, reason, message, date}, requestId, reference, signature }
// Recurrentes: sin requestId, con internalReference
// Firma: SHA-256(requestId + status.status + status.date + secretKey) con prefijo "sha256:"
//        o SHA-1 sin prefijo (esquema anterior)
// ==============================================================
$status_txt  = $data['status']['status'] ?? '';
$status_date = $data['status']['date'] ?? '';
$request_id  = (string)($data['requestId'] ?? $data['internalReference'] ?? '');
$reference   = (string)($data['reference'] ?? $data['payment'][0]['reference'] ?? '');
$signature   = (string)($data['signature'] ?? '');

if ($status_txt === '' || $request_id === '' || $signature === '') {
    http_response_code(400);
    echo json_encode(['status' => 'ERROR', 'message' => 'Datos incompletos']);
    exit();
}

// Validar firma probando los juegos de credenciales conocidos
$usa_sha256  = strpos($signature, 'sha256:') === 0;
$firma_plana = $usa_sha256 ? substr($signature, 7) : $signature;

$firma_ok = false;
foreach (P2P_CREDENCIALES as $cred) {
    $base = $request_id . $status_txt . $status_date . $cred['secretKey'];
    $calc = $usa_sha256 ? hash('sha256', $base) : sha1($base);
    if (hash_equals($calc, $firma_plana)) {
        $firma_ok = true;
        break;
    }
}

if (!$firma_ok) {
    http_response_code(403);
    echo json_encode(['status' => 'ERROR', 'message' => 'Firma invalida']);
    exit();
}

// Mapear estado
$nuevo_estado = match ($status_txt) {
    'APPROVED'           => 'aprobada',
    'APPROVED_PARTIAL'   => 'aprobada',
    'REJECTED', 'FAILED' => 'rechazada',
    'PENDING',
    'PENDING_VALIDATION' => 'pendiente',
    'REFUNDED'           => 'cancelada',
    default              => 'cancelada'
};

// Sin base de datos: se registra la notificación validada en el log en vez de
// persistir el estado en tablas.
file_put_contents(
    __DIR__ . '/notify_debug.log',
    date('Y-m-d H:i:s') . " | NOTIFY validado | ref=$reference | estado=$nuevo_estado\n\n",
    FILE_APPEND
);

// NOTA: la notificacion NO trae el token del medio de pago; para suscripciones
// se debe consultar la sesion via API tras el APPROVED.

// Responder 200 lo antes posible (PlaceToPay NO reintenta la notificacion)
http_response_code(200);
echo json_encode(['status' => 'OK']);