<?php
session_start();

// Sin base de datos: no hay órdenes persistidas que verificar contra PlaceToPay.
// La verificación de estado en vivo ocurre en las pantallas de retorno.
$redirect = $_GET['redirect'] ?? '../views/historial/historial.php';
$_SESSION['verify_msg'] = "No hay órdenes almacenadas para verificar.";
header("Location: $redirect");
exit();
