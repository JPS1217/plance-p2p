<?php
session_start();

// Sin base de datos: no hay transacciones aprobadas almacenadas que reversar.
$_SESSION['reverso_msg']      = 'ℹ️ No hay transacciones almacenadas para reversar.';
$_SESSION['reverso_msg_type'] = 'error';
header("Location: ../views/historial/reversos.php");
exit();
