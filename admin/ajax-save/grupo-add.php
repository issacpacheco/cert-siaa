<?php
include_once("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

if($_SESSION['nivel'] == 99){
    $qry="INSERT INTO area (nombre,estatus) VALUES ('$nombre','1')";
    echo '1';
}else if($_SESSION['nivel'] == 1){
    $qry="INSERT INTO inv_subareas (nombre,estatus,id_area) VALUES ('$nombre','1','{$_SESSION['area']}')";
    echo '1';
}

$ejecucion->ejecuta($qry);
