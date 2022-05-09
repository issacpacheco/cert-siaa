<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();


$producto       = $_REQUEST['producto'];
$cantidad       = $_REQUEST['cantidad'];
$id_resp        = filter_input(INPUT_POST, 'id_responsable', FILTER_SANITIZE_NUMBER_INT);
$campus_destino = filter_input(INPUT_POST, 'id_campus_destino', FILTER_SANITIZE_NUMBER_INT);
$idusuario      = $_SESSION['id_admin'];
$idcampus       = $_SESSION['campus'];

$codigo_transfer = "C".$_SESSION['campus']."-".date('ymd').'-'.$fn->generateRandomString(5);
$contador = count($producto);

for($i = 0; $i < $contador; $i++){
    $cantidad_actual = $info -> obtener_cantidad_material($producto[$i]);
    $resta = $cantidad_actual['cantidad'][0] - $cantidad[$i];

    $qryActualizarCantidad = "UPDATE inv_campus_producto SET cantidad = '$resta', mod_fecha_salida = curdate(), mod_hora_salida = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
    $ejecucion -> ejecuta($qryActualizarCantidad);

    $qryAgregaSalida = "INSERT INTO inv_salida_transferencia (id_usuario, fecha, hora, cantidad, id_producto, id_responsable, codigo_transfer, id_campus, id_campus_destino,estatus,cantidad_enviada)
                        VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$producto[$i]','$id_resp','$codigo_transfer','$idcampus','$campus_destino','1','$cantidad[$i]')";
    $id = $ejecucion -> ejecuta($qryAgregaSalida);

    $qryCodigoTransfer = "UPDATE inv_salida_transferencia SET codigo_transfer = '$codigo_transfer' WHERE id = '$id'";
    $ejecucion -> ejecuta($qryCodigoTransfer);
}