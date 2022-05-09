<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

$qry="INSERT INTO area (nombre,estatus) VALUES ('$nombre','1')";
echo $qry;

$ejecucion->ejecuta($qry);
