<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas;

use nsfunciones\funciones;
$fn = new funciones();

$filesize = $_FILES['file']['size'];
$filename = $_FILES['file']['name'];
$filenameb = $fn->replace_filename($filename);
$filename = $filenameb; 

$folio = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
if (!file_exists('../pdf/facturas/'.$folio))
{
    umask(0000);
    mkdir('../pdf/facturas/'.$folio,0777);
}
$location = "../pdf/facturas/" . $folio ."/". $filename;

$return_arr = array();

if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
    $src = "default.png";
    $src2="pdf/facturas/".$folio."/".$filename;
    $extension  = "pdf";
    // checking file is image or not
    if (is_array(getimagesize($location))) {
        $src = $location;
        $src2="pdf/facturas/".$folio."/".$filename;
        $file = new SplFileInfo($src2);
        $extension  = $file->getExtension();
    }
    $return_arr = array("name" => $filename, "size" => $filesize, "src" => $src2, "ext" => $extension);    
}

echo json_encode($return_arr);

