<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre         = filter_input(INPUT_POST, 'nombre',        FILTER_SANITIZE_STRING);
$cantidad       = filter_input(INPUT_POST, 'cantidad',      FILTER_SANITIZE_STRING);
$descripcion    = filter_input(INPUT_POST, 'descripcion',   FILTER_SANITIZE_STRING);
$codigo         = filter_input(INPUT_POST, 'codigo',        FILTER_SANITIZE_STRING);
$categoria      = filter_input(INPUT_POST, 'categoria',     FILTER_SANITIZE_NUMBER_INT);
$estatus        = filter_input(INPUT_POST, 'estatus',       FILTER_SANITIZE_NUMBER_INT);
$id             = filter_input(INPUT_POST, 'id_material',   FILTER_SANITIZE_NUMBER_INT);

$qry = "UPDATE inv_productos SET nombre = '$nombre', descripcion = '$descripcion', numero_serie = '$codigo', id_categoria = '$categoria', estatus = '$estatus' WHERE id = '$id'";

$ejecucion->ejecuta($qry);