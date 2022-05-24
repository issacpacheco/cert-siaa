<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas;

use nsfunciones\funciones;
$fn = new funciones();

$filesize = $_FILES['file']['size'];
$filename = $_FILES['file']['name'];
$filenameb = $fn->replace_filename($filenamec);
$filename = $filenameb; 

$folio = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
if (!file_exists('../upload/materiales/'.$folio))
{
    umask(0000);
    mkdir('../upload/materiales/'.$folio,0777);
}
$location = "../upload/materiales/" . $folio ."/". $filename;

$return_arr = array();

if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
    $src = "default.png";
    $src2="upload/materiales/".$folio."/".$filename;
    // $extension  = "pdf";
    // checking file is image or not
    if (is_array(getimagesize($location))) {
        $src = $location;
        $src2="upload/materiales/".$folio."/".$filename;
        $file = new SplFileInfo($src2);
        $extension  = $file->getExtension();
    }
    $return_arr = array("name" => $filename, "size" => $filesize, "src" => $src2);    
}

echo json_encode($return_arr);

