<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas;

use nsfunciones\funciones;
$fn = new funciones();

$filesize = $_FILES['file']['size'];
$filenamec = $_FILES['file']['name'];
$filenameb = $fn->replace_filename($filenamec);
$filename = $fn->generateRandomString(5)."_".$filenameb; 

$location = "../upload/materiales/" . $filename;
$id_material = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$return_arr = array();

if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
    $src = "default.png";

    // checking file is image or not
    if (is_array(getimagesize($location))) {
        $src = $location;
        $src2="upload/materiales/".$filename;
    }    

    $qry = "INSERT INTO  inv_producto_foto (foto, id_producto) VALUES ('$filename', '$id_material')";
    $idfoto = $ejecucion->ejecuta($qry);
    $return_arr = array("name" => $filename, "size" => $filesize, "src" => $src2, "idfoto" => $idfoto);    
}

echo json_encode($return_arr);
