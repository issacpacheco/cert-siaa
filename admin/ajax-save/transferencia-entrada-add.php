<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();

$idusuario  = $_SESSION['id_admin'];
$idcampus   = $_SESSION['campus'];
$id_campus_origen   = filter_input(INPUT_POST, 'id_campus_origen', FILTER_SANITIZE_NUMBER_INT);
$folio           = filter_input(INPUT_POST, 'folio', FILTER_SANITIZE_SPECIAL_CHARS);
$producto   = $_REQUEST['producto'];
$cantidad   = $_REQUEST['cantidad'];
$estatus    = $_REQUEST['estatus'];
$contador = count($producto);

for($i = 0; $i < $contador; $i++){
    $cantidad_actual = $info -> obtener_cantidad_material($producto[$i]);
    $suma = $cantidad_actual['cantidad'][0] + $cantidad[$i];

    //Se actualiza la cantidad del producto por la entrada
    $qryActualizarCantidad  = "UPDATE inv_campus_producto SET cantidad = '$suma', mod_fecha_entrada = curdate(), mod_hora_entrada = curtime(), mod_id_usuario = '$idusuario' 
                                WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
    $ejecucion              -> ejecuta($qryActualizarCantidad);
    //Se registra la entrada del producto por prestamo 
    $qryAgregaEntrada       = "INSERT INTO inv_entrada_transferencia (id_usuario, fecha, hora, cantidad, id_producto, codigo_transfer, id_campus, id_campus_origen, estatus) 
                                VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$producto[$i]','$folio','$idcampus','$id_campus_origen','$estatus[$i]')";
    $ejecucion              -> ejecuta($qryAgregaEntrada);
    //Se actualiza el estatus del prestamo del registro de salidas
    if($estatus[$i] == 3){
        $cantidad_prestada = $info -> obtener_cantidad_enviada($producto[$i],$folio);
        $resta = $cantidad_prestada['cantidad_enviada'][0] - $cantidad[$i];
        $qryActualizarTransferencia  = "UPDATE inv_salida_transferencia SET estatus = '$estatus[$i]', cantidad_enviada = '$resta' 
                                WHERE codigo_transfer = '$folio' AND id_producto = '$producto[$i]' AND estatus != 4";
        $ejecucion              -> ejecuta($qryActualizarTransferencia);
    }else if($estatus[$i] == 4){
        $cantidad_prestada = $info -> obtener_cantidad_enviada($producto[$i],$folio);
        $resta = $cantidad_prestada['cantidad'][0];
        $qryActualizarTransferencia  = "UPDATE inv_salida_transferencia SET estatus = '$estatus[$i]', cantidad_enviada = '$resta' 
                                WHERE codigo_transfer = '$folio' AND id_producto = '$producto[$i]' AND estatus != 4";
        $ejecucion              -> ejecuta($qryActualizarTransferencia);
    }
}