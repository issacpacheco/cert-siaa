<?php 
include("../class/allClass.php");

use nsalmacen\almacen;
use nsfunciones\funciones;
use conexionbd\mysqlconsultas;

$idcampus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_NUMBER_INT);
$idarea = filter_input(INPUT_GET, 'area', FILTER_SANITIZE_NUMBER_INT);

$almacen = new almacen();
$fn = new funciones();
$ejecucion = new mysqlconsultas();

$_SESSION['campus'] = $idcampus;
$_SESSION['area'] = $idarea;

$productos = $almacen->obtener_materiales();
$cproductos = $fn->cuentarray($productos);

for($i = 0; $i < $cproductos; $i++){
    $campusproducto     = $almacen->editar_campus_producto($idcampus,$productos['id'][$i]);
    $cantidad           = isset($campusproducto['cantidad'][0])             !== NULL   ? $campusproducto['cantidad'][0]             : "0";
    $modfechaentrada    = isset($campusproducto['mod_fecha_entrada'][0])    !== NULL   ? $campusproducto['mod_fecha_entrada'][0]    : "0";
    $modhoraentrada     = isset($campusproducto['mod_hora_entrada'][0])     !== NULL   ? $campusproducto['mod_hora_entrada'][0]     : "0";
    $modfechasalida     = isset($campusproducto['mod_fecha_salida'][0])     !== NULL   ? $campusproducto['mod_fecha_salida'][0]     : "0";
    $modhorasalida      = isset($campusproducto['mod_hora_salida'][0])      !== NULL   ? $campusproducto['mod_hora_salida'][0]      : "0";
    // $modfechafactrura   = !isset($campusproducto['mod_fecha_factura'][0])   !== NULL   ? $campusproducto['mod_fecha_factura'][0]    : "0";
    $modidusuario       = isset($campusproducto['mod_id_usuario'][0])       !== NULL   ? $campusproducto['mod_id_usuario'][0]       : "0";
    // echo $modfechaentrada;
    // echo ($modhoraentrada);




    $qry1 = "UPDATE inv_campus_producto SET cantidad = $cantidad, mod_fecha_entrada = '$modfechaentrada', mod_hora_entrada = '$modhoraentrada', mod_fecha_salida = '$modfechasalida', mod_hora_salida = '$modhorasalida', mod_id_usuario = '$modidusuario'
            WHERE id_campus = 2 AND id_producto = {$productos['id'][$i]}";
            echo $qry1.'<br>';
    $ejecucion->ejecuta($qry1);
    $qry2 = "UPDATE inv_campus_producto SET cantidad = NULL, 
                    mod_fecha_entrada = NULL, 
                    mod_hora_entrada = NULL, 
                    mod_fecha_salida = NULL, 
                    mod_hora_salida = NULL, 
                    mod_fecha_factura = NULL, 
                    mod_id_usuario = NULL 
            WHERE id_campus = 1 AND id_producto = {$productos['id'][$i]}";
    $ejecucion->ejecuta($qry2);
    $entradasproductos = $almacen->editar_entradas_productos($idcampus,$productos['id'][$i]);
    $qry3 = "UPDATE inv_entrada_producto SET id_campus = 2 WHERE id_campus = 1 AND id_producto = {$productos['id'][$i]}";
    $ejecucion->ejecuta($qry3);
    $salidasproductos = $almacen->editar_salida_productos($idcampus,$productos['id'][$i]);
    $qry4 = "UPDATE inv_salida_producto SET id_campus = 2 WHERE id_campus = 1 AND id_producto = {$productos['id'][$i]}";
    $ejecucion->ejecuta($qry4);
}