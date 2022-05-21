<?php
include("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(isset($id)){
    $qry1 = "DELETE FROM inv_productos WHERE id = $id";
    $ejecucion->ejecuta($qry1);

    $qry2 = "DELETE FROM inv_campus_producto WHERE id_producto = $id AND id_campus = 1";
    $ejecucion->ejecuta($qry2);
}else{
    echo "No haz escrito el id";
}

?>