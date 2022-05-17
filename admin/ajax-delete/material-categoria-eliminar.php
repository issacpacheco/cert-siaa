<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$idmaterial = filter_input(INPUT_POST, 'idmaterial', FILTER_SANITIZE_NUMBER_INT);
$idcategoria = filter_input(INPUT_POST, 'idcategoria', FILTER_SANITIZE_NUMBER_INT);

$qry = "UPDATE inv_productos SET id_categoria = NULL WHERE id = $idmaterial";
$ejecucion->ejecuta($qry);