<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);

$qry="INSERT INTO inv_categoria (nombre) VALUES ('$nombre')";
echo $qry;

$ejecucion->ejecuta($qry);