<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();


$producto   = $_REQUEST['producto'];
$cantidad   = $_REQUEST['cantidad'];
$id         = $_REQUEST['idsalida'];
$idusuario  = $_SESSION['id_admin'];
$estatus    = $_REQUEST['estatus'];
$idcampus   = $_SESSION['campus'];
//Obtenemos el id del solicitante
$idsolicitante = filter_input(INPUT_POST, 'idusuario', FILTER_SANITIZE_NUMBER_INT);

$contador = count($producto);
for($i = 0; $i < $contador; $i++){
    $cantidad_actual = $info -> obtener_cantidad_material($producto[$i]);
    $resta = $cantidad_actual['cantidad'][0] - $cantidad[$i];

    $qryActualizarCantidad = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_salida = curdate(), mod_hora_salida = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
    $ejecucion -> ejecuta($qryActualizarCantidad);

    $qryClavePrestamo = "UPDATE inv_salida_producto SET cantidad = '$cantidad[$i]', cantidad_prestada = '$cantidad[$i]', estatus = '$estatus[$i]', id_usuario_mod_pres = '$idusuario' WHERE id = '$id[$i]'";
    $ejecucion -> ejecuta($qryClavePrestamo);
}

