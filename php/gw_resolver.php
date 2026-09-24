<?php
session_start();

header('Content-Type: application/json');

// ══════════════════════════════════════════════════════════════
// gw_resolver.php — resolución diferida de transacciones "pendiente"
// simuladas en API Gateway (estados-gateway.php / estados-subs-gateway.php).
//
// SIN BASE DE DATOS: el estado diferido (resuelve_en / resuelve_a) lo dejó
// crear_*_gateway.php en la sesión, junto al resultado. Aquí, de forma
// "perezosa", si ya se cumplió `resuelve_en` se aplica `resuelve_a` sobre el
// resultado guardado en sesión y se devuelve el estado resultante.
// ══════════════════════════════════════════════════════════════

$claves_validas = [
    'orden'       => 'gw_result',
    'recurrencia' => 'gw_rec_result',
    'suscripcion' => 'gw_sus_result',
];

$tipo = $_GET['tipo'] ?? '';

if (!isset($claves_validas[$tipo])) {
    http_response_code(400);
    echo json_encode(['error' => 'parámetros inválidos']);
    exit();
}

$clave = $claves_validas[$tipo];
$res   = $_SESSION[$clave] ?? null;

if (!$res) {
    http_response_code(404);
    echo json_encode(['error' => 'no encontrado']);
    exit();
}

// Si sigue pendiente y ya se cumplió la hora de resolución, resolvemos ahora
if (($res['estado'] ?? '') === 'pendiente'
    && !empty($res['resuelve_en']) && !empty($res['resuelve_a'])
    && strtotime($res['resuelve_en']) <= time()) {

    $res['estado']      = $res['resuelve_a'];
    $res['resuelve_en'] = null;
    $res['resuelve_a']  = null;
    $_SESSION[$clave]   = $res;
}

echo json_encode(['estado' => $res['estado'] ?? 'pendiente']);
