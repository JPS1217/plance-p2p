<?php
// p2p_sonda_core.php — Helpers de PlaceToPay.
//
// SIN BASE DE DATOS: la sonda/reconciliación consultaba periódicamente las
// órdenes "pendiente" en la BD para reflejar su estado real. Al eliminarse la
// base de datos ya no hay filas persistidas que reconciliar, así que las
// funciones de sonda quedan como no-ops seguras (conservan su firma para que
// cualquier llamador siga resolviendo). Se conservan los helpers puros de
// autenticación, que las pantallas de pago en vivo (crear_*_gateway.php) sí
// usan para firmar sus peticiones al API.

require_once __DIR__ . '/p2p_config.php';

if (!function_exists('p2p_tablas_gateway')) {
    function p2p_tablas_gateway(): array {
        return ['gateway_ordenes', 'gateway_recurrencias', 'gateway_suscription'];
    }
}

if (!function_exists('p2p_credenciales_por_tabla')) {
    function p2p_credenciales_por_tabla(string $tabla): array {
        $creds = p2p_credenciales();
        if ($tabla === 'reservaciones') return $creds['preautorizacion'];
        if ($tabla === 'dispersiones')  return $creds['dispersion'];
        return $creds['principal'];
    }
}

// Firma de autenticación de PlaceToPay (usada en vivo por crear_*_gateway.php).
if (!function_exists('p2p_construir_auth')) {
    function p2p_construir_auth(string $login, string $secretKey): array {
        $seed    = date('c');
        $nonce   = bin2hex(random_bytes(16));
        $tranKey = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true));

        return [
            "login"   => $login,
            "tranKey" => $tranKey,
            "nonce"   => base64_encode($nonce),
            "seed"    => $seed,
        ];
    }
}

// ── No-ops sin base de datos (no hay filas que reconciliar) ──

if (!function_exists('p2p_consultar_y_actualizar')) {
    function p2p_consultar_y_actualizar($conexion, string $tabla, int $id, string $request_id): array {
        return ['ok' => false, 'mensaje' => 'sin base de datos: nada que actualizar'];
    }
}

if (!function_exists('p2p_recalcular_orden_mixta')) {
    function p2p_recalcular_orden_mixta($conexion, int $orden_id): void {
        // Sin base de datos: no-op.
    }
}

if (!function_exists('p2p_verificar_abono')) {
    function p2p_verificar_abono($conexion, int $abono_id, string $request_id): array {
        return ['ok' => false, 'mensaje' => 'sin base de datos: nada que verificar'];
    }
}

if (!function_exists('p2p_sonda_ejecutar')) {
    function p2p_sonda_ejecutar($conexion, array $tablas, int $margen_min, int $limite): array {
        $resumen = [];
        foreach ($tablas as $tabla) {
            $resumen[$tabla] = ['revisadas' => 0, 'actualizadas' => 0, 'detalle' => []];
        }
        return $resumen;
    }
}
