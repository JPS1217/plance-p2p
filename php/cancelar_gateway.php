<?php
session_start();

// Sin base de datos: no hay suscripciones almacenadas que cancelar.
$tabla = $_GET['tabla'] ?? 'gateway_recurrencias';
$modo_redirect = $tabla === 'gateway_suscription' ? 'gw-pura' : 'gw-sub';
$redirect = '../views/historial/reg-sus.php?modo=' . $modo_redirect;

$_SESSION['cancel_msg'] = 'ℹ️ No hay servicios almacenados para cancelar.';
header("Location: $redirect");
exit();
