<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$idfoto         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_material    = filter_input(INPUT_POST, 'idrelacion', FILTER_SANITIZE_NUMBER_INT);

$qry1 = "UPDATE inv_producto_foto SET favorito = 0 WHERE id_producto = '$id_material'";
$qry2 = "UPDATE inv_producto_foto SET favorito = 1 WHERE id = '$idfoto'";


$ejecucion->ejecuta($qry1);
$ejecucion->ejecuta($qry2);