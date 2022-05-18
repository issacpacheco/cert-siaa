<?php
error_reporting(0);
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info = new almacen();
$fn = new funciones();
$ejecucion = new mysqlconsultas();

$id             = filter_input(INPUT_POST, 'idproducto',    FILTER_SANITIZE_NUMBER_INT);
$folio          = filter_input(INPUT_POST, 'folio',         FILTER_SANITIZE_SPECIAL_CHARS);
$producto       = filter_input(INPUT_POST, 'producto',      FILTER_SANITIZE_SPECIAL_CHARS);
$cantidad       = filter_input(INPUT_POST, 'cantidad',      FILTER_SANITIZE_SPECIAL_CHARS);
$costo          = filter_input(INPUT_POST, 'costo',         FILTER_SANITIZE_SPECIAL_CHARS);

$idusuario      = $_SESSION['id_admin'];
$idcampus       = $_SESSION['campus'];

$idproducto     = $info -> obtener_material_nombre_id($id,$producto);

if(isset($idproducto)){
    $cantidad_actual = $info -> obtener_cantidad_material($idproducto['id'][0]);
    $suma = $cantidad_actual['cantidad'][0] + $cantidad;

    $qryActualizarCantidad = "UPDATE inv_campus_producto SET cantidad = '$suma', mod_fecha_entrada = curdate(), mod_hora_entrada = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '{$idproducto['id'][0]}' AND id_campus = '$idcampus'";
    $ejecucion -> ejecuta($qryActualizarCantidad);

    $qryAgregaEntrada = "INSERT INTO inv_entrada_producto (id_usuario, fecha, hora, cantidad, id_producto,id_campus,factura,total) VALUES ('$idusuario',curdate(),curtime(),'$cantidad','{$idproducto['id'][0]}','$idcampus','$folio','$costo')";
    $ejecucion -> ejecuta($qryAgregaEntrada);
    echo "1";
}else{
    echo "El producto no existe";
}


