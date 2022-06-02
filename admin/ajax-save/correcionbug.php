<?php
include("../class/allClass.php");

use nsalmacen\almacen;
use nsfunciones\funciones;
use conexionbd\mysqlconsultas;

$idcampus   = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_NUMBER_INT);
$idarea     = filter_input(INPUT_GET, 'area', FILTER_SANITIZE_NUMBER_INT);

$almacen    = new almacen();
$fn         = new funciones();
$ejecucion  = new mysqlconsultas();

$_SESSION['campus'] = $idcampus;
$_SESSION['area']   = $idarea;

$productos  = $almacen->obtener_materiales();
$cproductos = $fn->cuentarray($productos);
for($i = 0; $i < $cproductos; $i++){

    $idbodega       = isset($productos['id_bodega'][$i])    !== NULL ? $productos['id_bodega'][$i]      : "0";
    $idcategoria    = isset($productos['id_categoria'][$i]) !== NULL ? $productos['id_categoria'][$i]   : "0";
    $idestatus      = isset($productos['estatus'][$i])      !== NULL ? $productos['estatus'][$i]        : "0";
    $numeroserie    = isset($productos['numero_serie'][$i]) !== NULL ? $productos['numero_serie'][$i]   : "0";


    $qry1 = "UPDATE inv_campus_producto SET id_bodega = '$idbodega', id_categoria = '$idcategoria', id_estatus = '$idestatus', numero_serie = '$numeroserie'
            WHERE id_campus = {$idcampus} AND id_producto = {$productos['id'][$i]}";
            echo $qry1.'<br>';
    $ejecucion->ejecuta($qry1);
}
?>