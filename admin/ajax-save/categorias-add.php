<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

$qry="INSERT INTO inv_categoria (nombre,id_area) VALUES ('$nombre','{$_SESSION['area']}')";
echo '1';

$ejecucion->ejecuta($qry);
