<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion  = new mysqlconsultas();
$postload   = filter_input(INPUT_POST,      'returnpage',    FILTER_SANITIZE_SPECIAL_CHARS);
$div        = filter_input(INPUT_POST,      'div',           FILTER_SANITIZE_SPECIAL_CHARS);
$id         = filter_input(INPUT_POST,      'id',            FILTER_SANITIZE_NUMBER_INT);
$nombre     = filter_input(INPUT_POST,      'nombre',        FILTER_SANITIZE_SPECIAL_CHARS);
$descrip    = filter_input(INPUT_POST,      'descripcion',   FILTER_SANITIZE_SPECIAL_CHARS);

$qry = "UPDATE inv_subareas SET nombre = '$nombre', descripcion = '$descrip' WHERE id = '$id'";

$ejecucion->ejecuta($qry);
?>