<?php
include_once("../class/allClass.php");

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();
$ejecucion = new mysqlconsultas();

$idusuario  = $_SESSION['id_admin'];
$idcampus   = $_SESSION['campus'];
$prestamo   = filter_input(INPUT_POST, 'prestamo', FILTER_SANITIZE_NUMBER_INT);

if($prestamo == 1){
    
    $idsolicitante   = filter_input(INPUT_POST, 'idsolicitante',    FILTER_SANITIZE_NUMBER_INT);
    $folio           = filter_input(INPUT_POST, 'folio',            FILTER_SANITIZE_SPECIAL_CHARS);
    $comentarios     = filter_input(INPUT_POST, 'comentarios',      FILTER_SANITIZE_SPECIAL_CHARS);
    $producto        = $_REQUEST['producto'];
    $cantidad        = $_REQUEST['cantidad'];
    $estatus         = $_REQUEST['estatus'];
    $contador        = count($estatus);
    echo $contador;
    $consula = [];
    for($i = 0; $i < $contador; $i++){
        $cantidad_actual = $info -> obtener_cantidad_material($producto[$i]);
        $suma = $cantidad_actual['cantidad'][0] + $cantidad[$i];

        //Se actualiza la cantidad del producto por la entrada
        $qryActualizarCantidad  = "UPDATE inv_campus_producto SET cantidad = '$suma', mod_fecha_entrada = curdate(), mod_hora_entrada = curtime(), mod_id_usuario = '$idusuario' 
                                   WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
        $ejecucion              -> ejecuta($qryActualizarCantidad);
        //Se registra la entrada del producto por prestamo 
        $qryAgregaEntrada       = "INSERT INTO inv_entrada_producto (id_usuario, fecha, hora, cantidad, id_producto, devolucion, id_usuario_dev, clave_solicitud, id_campus,comentarios) 
                                   VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$producto[$i]','1','$idsolicitante', '$folio','$idcampus','$comentarios')";
        $ejecucion              -> ejecuta($qryAgregaEntrada);
        //Se actualiza el estatus del prestamo del registro de salidas
        if($estatus[$i] == "4"){
            $cantidad_prestada = $info -> obtener_cantidad_prestada($producto[$i],$folio);
            $resta = $cantidad_prestada['cantidad_prestada'][0] - $cantidad[$i];
            $qryActualizarPrestamo  = "UPDATE inv_salida_producto SET estatus = '$estatus[$i]', cantidad_prestada = '$resta', id_usuario_mod_pres = '$idusuario' 
                                       WHERE clave_solicitud = '$folio' AND id_producto = '$producto[$i]' AND estatus != 5";
            $ejecucion              -> ejecuta($qryActualizarPrestamo);
            $consula[] = "incompleto";
        }else if($estatus[$i] == "5"){
            $cantidad_prestada = $info -> obtener_cantidad_prestada($producto[$i],$folio);
            $resta = $cantidad_prestada['cantidad'][0];
            $qryActualizarPrestamo  = "UPDATE inv_salida_producto SET estatus = '$estatus[$i]', cantidad_prestada = '$resta', id_usuario_mod_pres = '$idusuario' 
                                       WHERE clave_solicitud = '$folio' AND id_producto = '$producto[$i]' AND estatus != 5";
            $ejecucion              -> ejecuta($qryActualizarPrestamo);
            $consula[] = "completo";
        }
    }
    var_dump($consula);

}else if($prestamo == 2){

    $factura     = filter_input(INPUT_POST, 'factura', FILTER_SANITIZE_SPECIAL_CHARS);
    $comentarios = filter_input(INPUT_POST, 'comentarios', FILTER_SANITIZE_SPECIAL_CHARS);
    $producto    = $_REQUEST['producto'];
    $cantidad    = $_REQUEST['cantidad'];
    $precio      = $_REQUEST['precio'];
    $contador    = count($producto);
    
    for($i = 0; $i < $contador; $i++){
        $cantidad_actual = $info -> obtener_cantidad_material($producto[$i]);
        $suma = $cantidad_actual['cantidad'][0] + $cantidad[$i];
    
        $qryActualizarCantidad = "UPDATE inv_campus_producto SET cantidad = '$suma', mod_fecha_entrada = curdate(), mod_hora_entrada = curtime(), mod_id_usuario = '$idusuario' WHERE id_producto = '$producto[$i]' AND id_campus = '$idcampus'";
        $ejecucion -> ejecuta($qryActualizarCantidad);
    
        $qryAgregaEntrada = "INSERT INTO inv_entrada_producto (id_usuario, fecha, hora, cantidad, id_producto,id_campus,factura,total,comentarios) VALUES ('$idusuario',curdate(),curtime(),'$cantidad[$i]','$producto[$i]','$idcampus','$factura','$precio[$i]','$comentarios')";
        $ejecucion -> ejecuta($qryAgregaEntrada);
    }

}