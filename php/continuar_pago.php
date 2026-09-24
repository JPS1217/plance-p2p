<?php
session_start();

// Sin base de datos: la continuación de un pago parcial dependía de una orden
// almacenada en el historial. Sin persistencia no hay saldo pendiente que
// retomar (el historial local por sesión es un paso posterior).
header("Location: ../views/historial/reg-pgb.php?modo=mixto");
exit();
