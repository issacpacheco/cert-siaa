<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre         = filter_input(INPUT_POST, 'nombre',         FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$usuario        = filter_input(INPUT_POST, 'usuario',        FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$contrasena     = filter_input(INPUT_POST, 'contrasena',     FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$val_contrasena = filter_input(INPUT_POST, 'val_contrasena', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nivel          = filter_input(INPUT_POST, 'niveles',        FILTER_SANITIZE_NUMBER_INT);
$subarea        = filter_input(INPUT_POST, 'subarea',        FILTER_SANITIZE_NUMBER_INT);
$campus         = $_SESSION['campus'];
$area           = $_SESSION['area'];

if($contrasena == $val_contrasena){
    $qry="INSERT INTO usuarios (nombre,correo,pass,id_campus,id_area,id_subarea,nivel) VALUES ('$nombre','$usuario','$contrasena','$campus','$area','$subarea','$nivel')";
    $ejecucion->ejecuta($qry);
    echo "1";
}else{
    echo "0";
}
