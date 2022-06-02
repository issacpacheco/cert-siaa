<?php 
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$idmaterial = filter_input(INPUT_POST, 'idmaterial', FILTER_SANITIZE_NUMBER_INT);
$idcategoria = filter_input(INPUT_POST, 'idcategoria', FILTER_SANITIZE_NUMBER_INT);

$qry = "UPDATE inv_campus_producto SET id_bodega = '$idcategoria' WHERE id_producto = $idmaterial AND id_campus = {$_SESSION['campus']}";
$ejecucion->ejecuta($qry);