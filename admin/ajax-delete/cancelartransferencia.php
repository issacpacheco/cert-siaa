<?php
include_once("../class/allClass.php");

$folio = filter_input(INPUT_POST, 'folio', FILTER_SANITIZE_SPECIAL_CHARS);
$idcampus = $_SESSION['campus'];
$idusuario = $_SESSION['id_admin'];
$campusdes = "2";
use nsalmacen\almacen;
use nsfunciones\funciones;
use conexionbd\mysqlconsultas;

$ejecucion = new mysqlconsultas();
$info   = new almacen();
$fn     = new funciones();

$tranferencia   = $info -> obtener_transferencia_eliminar($folio,$campusdes);
$ctranferencia  = $fn   -> cuentarray($tranferencia);

for($i = 0; $i < $ctranferencia; $i++){
    $cantidad_actual = $info -> obtener_cantidad_material($tranferencia['id_producto'][$i]);
    $suma = $cantidad_actual['cantidad'][0] + $tranferencia['cantidad'][$i];

    //Se actualiza la cantidad del producto por la entrada
    $qryActualizarCantidad  = "UPDATE inv_campus_producto SET cantidad = '$suma', mod_fecha_entrada = curdate(), mod_hora_entrada = curtime(), mod_id_usuario = '$idusuario' 
                                WHERE id_producto = '".$tranferencia['id_producto'][$i]."' AND id_campus = '$idcampus'";
    $ejecucion              -> ejecuta($qryActualizarCantidad);
}
$qryEliminar = "DELETE FROM inv_salida_transferencia WHERE codigo_transfer = '$folio'";
$ejecucion -> ejecuta($qryEliminar);