<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion  = new mysqlconsultas();
$clave = filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_SPECIAL_CHARS);

$qry = "UPDATE inv_salida_transferencia SET estatus = 2 WHERE codigo_transfer = '$clave'";

$ejecucion->ejecuta($qry);