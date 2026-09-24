<?php
// cron/sonda.php — Sonda / cronjob de estados de PlaceToPay.
//
// Revisa periodicamente las ordenes que quedaron en "pendiente" porque el
// webhook (php/notify.php) no llego o el usuario no volvio a retorno/*.php,
// y las vuelve a consultar contra PlaceToPay para reflejar el estado real.
//
// Uso local (XAMPP, Windows) — probar a mano:
//   C:\xampp\php\php.exe cron\sonda.php
//
// Produccion con cron nativo (cPanel, VPS con crontab):
//   */5 * * * * php /ruta/al/proyecto/cron/sonda.php >> /ruta/al/proyecto/cron/sonda.log 2>&1
//
// Solo corre por linea de comandos. Para hosting sin cron nativo existe el
// equivalente por HTTP (con token) en cron/sonda_http.php.

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Este script solo se ejecuta por linea de comandos.');
}

require_once __DIR__ . '/../php/env.php';
require_once __DIR__ . '/../php/p2p_sonda_core.php';
$conexion = null; // sin base de datos

// Tablas a revisar y minutos de margen antes de considerar una orden
// "abandonada" (evita chocar con un pago que el usuario todavia esta
// completando en el navegador).
$TABLAS = [
    'ordenes', 'gateway_ordenes',                                    // pago basico: Web Checkout / API Gateway
    'suscripciones', 'suscription', 'gateway_recurrencias', 'gateway_suscription', // suscripciones
    'recurrencias', 'suscription_rec',                                // pagos recurrentes
];
$MARGEN_MIN = (int) env_get('SONDA_MARGEN_MIN', 5);
$LIMITE     = (int) env_get('SONDA_LIMITE', 50);

$resumen = p2p_sonda_ejecutar($conexion, $TABLAS, $MARGEN_MIN, $LIMITE);

$linea = date('Y-m-d h:i:s A') . " | Sonda ejecutada (margen {$MARGEN_MIN}min)\n";
foreach ($resumen as $tabla => $r) {
    if (isset($r['error'])) {
        $linea .= "  - $tabla: ERROR " . $r['error'] . "\n";
        continue;
    }
    $linea .= "  - $tabla: {$r['revisadas']} revisadas, {$r['actualizadas']} actualizadas\n";
    foreach ($r['detalle'] as $d) {
        $linea .= "      $d\n";
    }
}

file_put_contents(__DIR__ . '/sonda.log', $linea . "\n", FILE_APPEND);
echo $linea;
