<?php
include_once("../class/allClass.php");
include_once("../../includes/funciones.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();


$producto           = $_REQUEST['producto'];
$cantidad           = $_REQUEST['cantidad'];
$id_departamento    = $_REQUEST['id_departamento'];
$idusuario          = $_SESSION['id_admin'];
$idcampus           = $_SESSION['campus'];
$contador           = count($producto);
for($i = 0; $i < $contador; $i++){
    $cantidad_actual        = $info -> obtener_cantidad_material($producto[$i]);
    $resta                  = $cantidad_actual['cantidad'][0] - $cantidad[$i];

    $qryActualizarCantidad  = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_salida = curdate(), mod_hora_salida = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
    $ejecucion              -> ejecuta($qryActualizarCantidad);

    $qryAgregaEntrada       = "INSERT INTO inv_salida_producto (id_usuario, fecha, hora, cantidad, id_producto,id_campus,estatus,id_departamento) 
                                VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$producto[$i]','$idcampus','0','$id_departamento')";
    $id = $ejecucion        -> ejecuta($qryAgregaEntrada);
}
if($id > 0){
    echo "1";
}else{
    echo "0";
}
