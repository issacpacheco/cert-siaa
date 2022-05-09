<?php
   error_reporting(0);
   header("Content-Type: text/html; charset=UTF-8");
   ini_set('display_errors', '1');
   include('../class/allClass.php');
   $destruir = filter_input(INPUT_GET,'destruir',FILTER_SANITIZE_NUMBER_INT);



   use nsnewsesion\newsesion;
   $sessionclass = new newsesion();

   if($destruir == 1){
      $session = $sessionclass->destruir();
   }

   $session = $sessionclass->leerDatos();
   echo $session;
?>