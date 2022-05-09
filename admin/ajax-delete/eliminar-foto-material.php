<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$idfoto = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$fototour = filter_input(INPUT_POST, 'foto', FILTER_SANITIZE_STRING);

$qry="delete from inv_producto_foto where id = '$idfoto'";
$ejecucion->ejecuta($qry);

unlink('../upload/materiales/'.$fototour);