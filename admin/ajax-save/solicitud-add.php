<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();


$producto   = $_REQUEST['producto'];
$cantidad   = $_REQUEST['cantidad'];
// $idusuario  = $_SESSION['id_admin'];
$idcampus   = $_SESSION['campus'];


//Obtenemos el id del solicitante
$idsolicitante = $_SESSION['id_admin'];
//Generamos una clave para el prestamo
$claveprestamo = "C".$_SESSION['campus']."-".date('ymd').'-'.$fn->generateRandomString(5);

$contador = count($producto);
for($i = 0; $i < $contador; $i++){

    $qryAgregaEntrada = "INSERT INTO inv_salida_producto (fecha, hora, cantidad, cantidad_prestada,id_producto, id_solicitante, prestamo, estatus,id_campus) 
                        VALUES (curdate(),curtime(),'$cantidad[$i]','$cantidad[$i]','$producto[$i]','$idsolicitante','1','1','$idcampus')";
    $id = $ejecucion -> ejecuta($qryAgregaEntrada);

    $qryClavePrestamo = "UPDATE inv_salida_producto SET clave_solicitud = '$claveprestamo' WHERE id = '$id'";
    $ejecucion -> ejecuta($qryClavePrestamo);
}

