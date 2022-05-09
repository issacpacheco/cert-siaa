<?php 
include('../class/allClass.php');

$id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_SPECIAL_CHARS);
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

if($id_producto == 'NA'){
    echo "0";
}else{
    $prestamos   = $info -> obtener_cantidad_material($id_producto);

    echo $prestamos['cantidad'][0];
}