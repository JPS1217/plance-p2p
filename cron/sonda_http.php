<?php
// cron/sonda_http.php — Version HTTP de la sonda, protegida por token.
//
// Pensada para comercios cuyo hosting NO ofrece cron nativo: se dispara con
// un GET periodico desde un servicio externo (cron-job.org, EasyCron, etc.)
// contra:
//
//   https://tu-dominio.com/ruta/cron/sonda_http.php?token=TU_TOKEN
//
// El token se define en .env como CRON_TOKEN (genera uno largo y aleatorio
// por comercio). Si no esta configurado, el endpoint se niega a correr
// (fail closed) para no quedar expuesto sin autenticacion.

require_once __DIR__ . '/../php/env.php';

header('Content-Type: application/json');

if (!in_array($_SERVER['REQUEST_METHOD'] ?? '', ['GET', 'HEAD'], true)) {
    http_response_code(405);
    echo json_encode(['status' => 'ERROR', 'message' => 'Metodo no permitido']);
    exit();
}

$token_config   = (string) env_get('CRON_TOKEN', '');
$token_recibido = (string) ($_GET['token'] ?? '');

if ($token_config === '') {
    http_response_code(500);
    echo json_encode(['status' => 'ERROR', 'message' => 'CRON_TOKEN no configurado en .env']);
    exit();
}

if (!hash_equals($token_config, $token_recibido)) {
    http_response_code(403);
    echo json_encode(['status' => 'ERROR', 'message' => 'Token invalido']);
    exit();
}

// El servicio externo suele hacer un HEAD de verificacion antes de programar
// el GET periodico: se responde 200 sin tocar la BD.
if ($_SERVER['REQUEST_METHOD'] === 'HEAD') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../php/p2p_sonda_core.php';
$conexion = null; // sin base de datos

$TABLAS = [
    'ordenes', 'gateway_ordenes',                                    // pago basico: Web Checkout / API Gateway
    'suscripciones', 'suscription', 'gateway_recurrencias', 'gateway_suscription', // suscripciones
    'recurrencias', 'suscription_rec',                                // pagos recurrentes
];
$MARGEN_MIN = (int) env_get('SONDA_MARGEN_MIN', 5);
$LIMITE     = (int) env_get('SONDA_LIMITE', 50);

$resumen = p2p_sonda_ejecutar($conexion, $TABLAS, $MARGEN_MIN, $LIMITE);

$linea = date('Y-m-d h:i:s A') . " | Sonda HTTP ejecutada | IP: " . ($_SERVER['REMOTE_ADDR'] ?? '?') . "\n";
foreach ($resumen as $tabla => $r) {
    if (isset($r['error'])) {
        $linea .= "  - $tabla: ERROR " . $r['error'] . "\n";
        continue;
    }
    $linea .= "  - $tabla: {$r['revisadas']} revisadas, {$r['actualizadas']} actualizadas\n";
}
file_put_contents(__DIR__ . '/sonda.log', $linea . "\n", FILE_APPEND);

http_response_code(200);
echo json_encode(['status' => 'OK', 'resumen' => $resumen]);
