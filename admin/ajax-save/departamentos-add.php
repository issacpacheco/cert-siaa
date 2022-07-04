<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre         = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion    = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);

$qry="INSERT INTO inv_departamentos (nombre,descripcion,id_campus) VALUES ('$nombre','$descripcion',{$_SESSION['campus']})";
echo '1';

$ejecucion->ejecuta($qry);
