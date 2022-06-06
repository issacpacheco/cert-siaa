<?php
include_once("../class/allClass.php");
include_once("../../includes/funciones.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();


$producto    = $_REQUEST['producto'];
$cantidad    = $_REQUEST['cantidad'];
$proyecto    = $_REQUEST['id_proyecto'];
$idusuario   = $_SESSION['id_admin'];
$idcampus    = $_SESSION['campus'];
$prestamo    = filter_input(INPUT_POST, 'prestamo', FILTER_SANITIZE_NUMBER_INT);
$comentarios = filter_input(INPUT_POST, 'comentarios', FILTER_SANITIZE_SPECIAL_CHARS);
$fechas      = $_REQUEST['fechas'];

if($prestamo == 1){
    //Obtenemos el id del solicitante
    $idsolicitante  = filter_input(INPUT_POST, 'idusuario', FILTER_SANITIZE_NUMBER_INT);
    //Generamos una clave para el prestamo
    $claveprestamo  = "C".$_SESSION['campus']."-".date('ymd').'-'.$fn->generateRandomString(5);
    $check          = filter_input(INPUT_POST, 'listavacia', FILTER_SANITIZE_NUMBER_FLOAT);
    $_SESSION['claveprestamo'] = $claveprestamo;
    $contador       = count($producto);
    if($idsolicitante < 1){
        if(isset($check)){
            $nuevoNombre    = filter_input(INPUT_POST, 'nombrenuevousuario', FILTER_SANITIZE_SPECIAL_CHARS);
            $grado          = filter_input(INPUT_POST, 'grado', FILTER_SANITIZE_SPECIAL_CHARS);
            $grupo          = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_SPECIAL_CHARS);
            $carrera        = filter_input(INPUT_POST, 'carrera', FILTER_SANITIZE_SPECIAL_CHARS);
            $docente        = filter_input(INPUT_POST, 'validacionadmin', FILTER_SANITIZE_NUMBER_FLOAT);
            if($docente == 1){
                $tip = $docente;
            }else{
                $tip = 0;
            }
            $qryNuevoUsuario = "INSERT INTO inv_usuario (nombre, grado, grupo, carrera, docente, id_campus, id_area) VALUES ('$nuevoNombre','$grado','$grupo','$carrera','$tip', '{$_SESSION['campus']}','{$_SESSION['area']}')";
            $idsolicitante = $ejecucion->ejecuta($qryNuevoUsuario);
        }
    }
    for($i = 0; $i < $contador; $i++){
        $cantidad_actual        = $info -> obtener_cantidad_material($producto[$i]);
        $resta                  = $cantidad_actual['cantidad'][0] - $cantidad[$i];

        $fecha1                 = substr( $fechas[$i], 0, 2 ) . '/' . substr( $fechas[$i], 3, 2 ) . '/' . substr( $fechas[$i], 6, 4 );
        $fecha2                 = substr( $fechas[$i], 13, 2 ) . '/' . substr( $fechas[$i], 16, 2 ) . '/' . substr( $fechas[$i], 19, 4 );
        $fecha_ini              = FormatoFechaReportes($fecha1);
        $fecha_fin              = FormatoFechaReportes($fecha2);

        $qryActualizarCantidad  = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_salida = curdate(), mod_hora_salida = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
        $ejecucion              -> ejecuta($qryActualizarCantidad);
    
        $qryAgregaEntrada       = "INSERT INTO inv_salida_producto (id_usuario, fecha, hora, cantidad, cantidad_prestada,id_producto, id_solicitante, prestamo, estatus,id_campus,comentarios,fch_ini,fch_fin) 
                                    VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$cantidad[$i]','$producto[$i]','$idsolicitante','1','3','$idcampus','$comentarios','$fecha_ini','$fecha_fin')";
        $id = $ejecucion        -> ejecuta($qryAgregaEntrada);

        $qryClavePrestamo       = "UPDATE inv_salida_producto SET clave_solicitud = '$claveprestamo' WHERE id = '$id'";
        $ejecucion              -> ejecuta($qryClavePrestamo);
    }

}else if($prestamo == 2){
    $contador = count($producto);
    $idgrupo  = filter_input(INPUT_POST, 'idgrupo', FILTER_SANITIZE_NUMBER_INT);
    for($i = 0; $i < $contador; $i++){
        $cantidad_actual        = $info -> obtener_cantidad_material($producto[$i]);
        $resta                  = $cantidad_actual['cantidad'][0] - $cantidad[$i];

        $qryActualizarCantidad  = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_salida = curdate(), mod_hora_salida = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
        $ejecucion              -> ejecuta($qryActualizarCantidad);

        $qryAgregaEntrada       = "INSERT INTO inv_salida_producto (id_usuario, fecha, hora, cantidad, id_producto, id_solicitante,id_campus,estatus,proyecto,comentarios,id_subarea) 
                                    VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$producto[$i]','$idsolicitante','$idcampus','0','$proyecto[$i]','$comentarios','$idgrupo')";
        $id = $ejecucion        -> ejecuta($qryAgregaEntrada);
    }
}