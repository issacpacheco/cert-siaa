<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$fn         = new funciones();
$info       = new almacen();
$ejecucion  = new mysqlconsultas();

$id         = filter_input(INPUT_POST, 'id',            FILTER_SANITIZE_NUMBER_INT);
$idproducto = filter_input(INPUT_POST, 'idproducto',    FILTER_SANITIZE_NUMBER_INT);
$folio      = filter_input(INPUT_POST, 'folio',         FILTER_SANITIZE_SPECIAL_CHARS);
// echo $id.'<br>';
// echo $idproducto.'<br>';
// echo $folio.'<br>';
$material   = $info -> obtener_material($idproducto);

$factura    = $info -> obtener_columna_factura($id,$idproducto,$folio);

$cantidadActual = $material['cantidad'][0];
$cantidadFactura = $factura['cantidad'][0];
// echo $cantidadActual.'<br>';
// echo $cantidadFactura.'<br>';
if($cantidadActual < $cantidadFactura){
    echo "0";
}else{
    $resta = ($cantidadActual - $cantidadFactura);
    $qry = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_factura = CURDATE() WHERE id_producto = $idproducto AND id_campus = {$_SESSION['campus']}";
    $resp = $ejecucion->ejecuta($qry);
    $qry = "DELETE FROM inv_entrada_producto WHERE id = $id";
    $ejecucion->ejecuta($qry);
    echo "1";
}