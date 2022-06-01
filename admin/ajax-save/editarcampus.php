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
    $campusproducto = $almacen->editar_campus_producto($idcampus,$productos['id'][$i]);
    $qry = "UPDATE inv_campus_producto SET cantidad = ".$campusproducto['cantidad'][0].", 
                    mod_fecha_entrada = ".isset($campusproducto['mod_fecha_entrada'][0]) ? $campusproducto['mod_fecha_entrada'][0] : NULL.", 
                    mod_hora_entrada = ".isset($campusproducto['mod_hora_entrada'][0]) ? $campusproducto['mod_hora_entrada'][0] : NULL.", 
                    mod_fecha_salida = ".$campusproducto['mod_fecha_salida'][0].", 
                    mod_hora_salida = ".$campusproducto['mod_hora_salida'][0].", 
                    mod_fecha_factura = ".$campusproducto['mod_fecha_factura'][0].", 
                    mod_id_usuario = ".$campusproducto['mod_id_usuario'][0]."
            WHERE id_campus = 2 AND id_producto = {$productos['id'][$i]}";
    $ejecucion->ejecuta($qry);
    $qry = "UPDATE inv_campus_producto SET cantidad = NULL, 
                    mod_fecha_entrada = NULL, 
                    mod_hora_entrada = NULL, 
                    mod_fecha_salida = NULL, 
                    mod_hora_salida = NULL, 
                    mod_fecha_factura = NULL, 
                    mod_id_usuario = NULL 
            WHERE id_campus = 1 AND id_producto = {$productos['id'][$i]}";
    $ejecucion->ejecuta($qry);
    $entradasproductos = $almacen->editar_entradas_productos($idcampus,$productos['id'][$i]);
    $qry = "UPDATE inv_entrada_producto SET id_campus = 2 WHERE id_campus = 1 AND id_producto = {$productos['id'][$i]}";
    $ejecucion->ejecuta($qry);
    $salidasproductos = $almacen->editar_salida_productos($idcampus,$productos['id'][$i]);
    $qry = "UPDATE inv_salida_producto SET id_campus = 2 WHERE id_campus = 1 AND id_producto = {$productos['id'][$i]}";
    $ejecucion->ejecuta($qry);
}