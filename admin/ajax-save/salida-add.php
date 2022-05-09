<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();


$producto    = $_REQUEST['producto'];
$cantidad    = $_REQUEST['cantidad'];
$proyecto    = $_REQUEST['proyecto'];
$idusuario   = $_SESSION['id_admin'];
$idcampus    = $_SESSION['campus'];
$prestamo    = filter_input(INPUT_POST, 'prestamo', FILTER_SANITIZE_NUMBER_INT);
$comentarios = filter_input(INPUT_POST, 'comentarios', FILTER_SANITIZE_SPECIAL_CHARS);

if($prestamo == 1){
    //Obtenemos el id del solicitante
    $idsolicitante = filter_input(INPUT_POST, 'idusuario', FILTER_SANITIZE_NUMBER_INT);
    //Generamos una clave para el prestamo
    $claveprestamo = "C".$_SESSION['campus']."-".date('ymd').'-'.$fn->generateRandomString(5);

    $contador = count($producto);
    for($i = 0; $i < $contador; $i++){
        $cantidad_actual = $info -> obtener_cantidad_material($producto[$i]);
        $resta = $cantidad_actual['cantidad'][0] - $cantidad[$i];
    
        $qryActualizarCantidad = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_salida = curdate(), mod_hora_salida = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
        $ejecucion -> ejecuta($qryActualizarCantidad);
    
        $qryAgregaEntrada = "INSERT INTO inv_salida_producto (id_usuario, fecha, hora, cantidad, cantidad_prestada,id_producto, id_solicitante, prestamo, estatus,id_campus,comentarios) 
                            VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$cantidad[$i]','$producto[$i]','$idsolicitante','1','3','$idcampus','$comentarios')";
        $id = $ejecucion -> ejecuta($qryAgregaEntrada);

        $qryClavePrestamo = "UPDATE inv_salida_producto SET clave_solicitud = '$claveprestamo' WHERE id = '$id'";
        $ejecucion -> ejecuta($qryClavePrestamo);
    }

}else if($prestamo == 2){
    $contador = count($producto);
    for($i = 0; $i < $contador; $i++){
        $cantidad_actual = $info -> obtener_cantidad_material($producto[$i]);
        $resta = $cantidad_actual['cantidad'][0] - $cantidad[$i];

        $qryActualizarCantidad = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_salida = curdate(), mod_hora_salida = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
        $ejecucion -> ejecuta($qryActualizarCantidad);

        $qryAgregaEntrada = "INSERT INTO inv_salida_producto (id_usuario, fecha, hora, cantidad, id_producto, id_solicitante,id_campus,estatus,proyecto,comentarios) 
                            VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$producto[$i]','$idsolicitante','$idcampus','0','$proyecto[$i]','$comentarios')";
        $id = $ejecucion -> ejecuta($qryAgregaEntrada);
    }
}