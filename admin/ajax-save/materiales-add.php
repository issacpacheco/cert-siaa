<?php
error_reporting(0);
include_once("../class/allClass.php");
// require('UploadHandler.php');
// $upload_handler = new UploadHandler();
use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info = new almacen();
$fn = new funciones();
$ejecucion = new mysqlconsultas();


$nombre         = filter_input(INPUT_POST, 'nombre',        FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion    = filter_input(INPUT_POST, 'descripcion',   FILTER_SANITIZE_SPECIAL_CHARS);
$codigo         = filter_input(INPUT_POST, 'codigo',        FILTER_SANITIZE_SPECIAL_CHARS);
$categoria      = filter_input(INPUT_POST, 'categoria',     FILTER_SANITIZE_NUMBER_INT);
$estatus        = filter_input(INPUT_POST, 'estatus',       FILTER_SANITIZE_NUMBER_INT);
$unidad         = filter_input(INPUT_POST, 'unidad',        FILTER_SANITIZE_NUMBER_INT);
$bodega         = filter_input(INPUT_POST, 'bodega',        FILTER_SANITIZE_NUMBER_INT);
$idusuario      = $_SESSION['id_admin'];
$idcampus       = $_SESSION['campus'];
$area           = $_SESSION['area'];


$qry = "INSERT INTO inv_productos (nombre,descripcion,fecha_registro,hora_registro,id_usuario_alta,id_area,id_unidad) 
        VALUES ('$nombre','$descripcion',curdate(),curtime(),'$idusuario','$area','$unidad')";

$id = $ejecucion->ejecuta($qry);
//Crear carpeta
// rename("../images/productos/temp_bak","../images/productos/".$id);
// rename("../images/productos/temp_bak/medium","../images/productos/".$id."/medium");
// rename("../images/productos/temp_bak/thumb","../images/productos/".$id."/thumb");

$campus = $info->obtener_todos_almacenes();
$ccampus = $fn->cuentarray($campus);

for($i = 0; $i < $ccampus; $i++){
        $qry = "INSERT INTO inv_campus_producto (id_producto, id_campus, cantidad, id_categoria, id_estatus, id_bodega, numero_serie) VALUES ('$id', '{$campus['id'][$i]}','0','$categoria','$estatus','$bodega', '$codigo')";
        $ejecucion->ejecuta($qry);
}