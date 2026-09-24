<?php
session_start();

// Sin base de datos: no hay transacciones que detallar. Volver al listado.
header("Location: reversos.php");
exit();