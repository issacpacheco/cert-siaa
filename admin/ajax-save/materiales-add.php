<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info = new almacen();
$fn = new funciones();
$ejecucion = new mysqlconsultas();


$nombre         = filter_input(INPUT_POST, 'nombre',        FILTER_SANITIZE_STRING);
$descripcion    = filter_input(INPUT_POST, 'descripcion',   FILTER_SANITIZE_STRING);
$codigo         = filter_input(INPUT_POST, 'codigo',        FILTER_SANITIZE_STRING);
$categoria      = filter_input(INPUT_POST, 'categoria',     FILTER_SANITIZE_NUMBER_INT);
$estatus        = filter_input(INPUT_POST, 'estatus',       FILTER_SANITIZE_NUMBER_INT);
$idusuario      = $_SESSION['id_admin'];
$idcampus       = $_SESSION['campus'];
$area           = $_SESSION['area'];


$qry = "INSERT INTO inv_productos (nombre,descripcion,numero_serie,fecha_registro,hora_registro,id_usuario_alta,id_categoria,estatus) 
        VALUES ('$nombre','$descripcion','$codigo',curdate(),curtime(),'$idusuario','$categoria','$estatus','$area')";

$id = $ejecucion->ejecuta($qry);

$campus = $info->obtener_todos_almacenes();
$ccampus = $fn->cuentarray($campus);

for($i = 0; $i < $ccampus; $i++){
        $qry = "INSERT INTO inv_campus_producto (id_producto, id_campus, cantidad) VALUES ('$id', '{$campus['id'][$i]}','0')";
        $ejecucion->ejecuta($qry);
}