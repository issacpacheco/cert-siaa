<?php
require('../class/allClass.php');
error_reporting(0);
$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
$contra  = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

use nsnewsesion\newsesion;
use nsfunciones\funciones;

$fn = new funciones();
$get = new newsesion();

$logeo = $get->login($usuario, $contra);
// $clogeo = $fn->cuentarray($logeo);
$inicio = $logeo['id'][0];

if($inicio > 0){
    $id             = $logeo['id'][0];
    $id_campus      = $logeo['id_campus'][0];
    $id_area        = $logeo['id_area'][0];
    $nombre         = $logeo['nombre'][0];
    $nivel          = $logeo['nivel'][0];
    $nueva_sesion   = $get->crearsesion($id, $id_campus, $id_area, $nombre, $nivel);
    echo "1";
}else{
    echo "0";
	exit();	
}
?>