<?php
session_start();

// Sin base de datos: no hay suscripciones almacenadas que cancelar.
// (La gestión/cancelación de servicios persistidos es un paso posterior.)
$tabla = $_GET['tabla'] ?? 'recurrencias';
if ($tabla === 'suscription_rec') {
    $redirect = '../views/historial/reg-sus.php?modo=wc-rec';
} else {
    $redirect = '../views/historial/reg-rec.php';
}

$_SESSION['cancel_msg'] = 'ℹ️ No hay servicios almacenados para cancelar.';
header("Location: $redirect");
exit();
