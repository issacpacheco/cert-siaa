<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre         = filter_input(INPUT_POST, 'nombre',              FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$usuario        = filter_input(INPUT_POST, 'correo',              FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$contrasena     = filter_input(INPUT_POST, 'contrasena_personal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nivel          = filter_input(INPUT_POST, 'niveles',             FILTER_SANITIZE_NUMBER_INT);
$subarea        = filter_input(INPUT_POST, 'id_subarea',          FILTER_SANITIZE_NUMBER_INT);
$id             = filter_input(INPUT_POST, 'id_usuario',          FILTER_SANITIZE_NUMBER_INT);
$edicionPerfil  = filter_input(INPUT_POST, 'edicionPerfil',       FILTER_SANITIZE_NUMBER_INT);
if($_SESSION['nivel'] == 99){
    $area           = filter_input(INPUT_POST, 'id_area',        FILTER_SANITIZE_NUMBER_INT);
    $qry = "UPDATE usuarios SET nombre = '$nombre', correo = '$usuario', pass = '$contrasena', id_area = '$area', id_subarea = '$subarea', nivel = '$nivel' WHERE id = $id";
    $ejecucion->ejecuta($qry);

}else{
    if($edicionPerfil == 1){
        $qry = "UPDATE usuarios SET nombre = '$nombre', correo = '$usuario', pass = '$contrasena' WHERE id = $id";
        $ejecucion->ejecuta($qry);
    }else if($edicionPerfil == 2){
        $qry = "UPDATE usuarios SET nombre = '$nombre', correo = '$usuario', pass = '$contrasena', id_subarea = '$subarea', nivel = '$nivel' WHERE id = $id";
        $ejecucion->ejecuta($qry);
    }
    
}

