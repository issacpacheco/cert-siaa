<?php
ini_set('memory_limit', '512M');
$conexion = mysqli_connect("localhost","root","fabricandomarcas","cert");
mysqli_query($conexion,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$conexion2 = mysqli_connect("localhost","root","fabricandomarcas","examen_psicometrico");
mysqli_query($conexion2,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$conexion3 = mysqli_connect("localhost","root","fabricandomarcas","examen_diagnostico");
mysqli_query($conexion3,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


date_default_timezone_set('America/Mexico_City');
$hoy = date("Y-m-d");
$hora = date('H:i:s');
$anio = substr($hoy,0,4);
?>