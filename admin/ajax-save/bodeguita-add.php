<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);

$qry="INSERT INTO inv_bodeguitas (nombre,id_area,estatus) VALUES ('$nombre','{$_SESSION['area']}',1)";
echo '1';

$ejecucion->ejecuta($qry);