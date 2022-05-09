<?php 
error_reporting(0);
include_once("../class/allClass.php");
// require_once('../scripts/PHPExcel/Reader/Excel2007.php');

use conexionbd\mysqlconsultas;
use nsalmacen\almacen;
use nsfunciones\funciones;

$fn     	= new funciones();
$info 		= new almacen();
$ejecucion 	= new mysqlconsultas();

// extract($_POST);
// if (isset($_POST['action'])) {
// 	$action = $_POST['action'];
// }
// echo $_POST['action'];

// if (isset($action) == "action"){
	//cargamos el fichero
	$archivo 	= $_FILES['excel']['name'];
	$tipo 		= $_FILES['excel']['type'];
	$destino 	= "cop_".$archivo;//Le agregamos un prefijo para identificarlo el archivo cargado

	if (copy($_FILES['excel']['tmp_name'],$destino)){ 
		echo "Archivo Cargado Con Éxito";
	}else{
		echo "Error Al Cargar el Archivo";
	}
			
	if (file_exists ("cop_".$archivo)){ 

		// Cargando la hoja de excel
		$objReader = new PHPExcel_Reader_Excel2007();
		$objPHPExcel = $objReader->load("cop_".$archivo);	
		$objFecha = new PHPExcel_Shared_Date();       
		// Asignamon la hoja de excel activa
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido

		$columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
		$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

		//Creamos un array con todos los datos del Excel importado
		for ($i=2;$i<=$filas;$i++){
			//obtenemos la hora actual
			date_default_timezone_set('America/Cancun');
			setlocale(LC_TIME, 'es_ES.UTF-8');
			setlocale(LC_TIME, 'spanish');
			setlocale (LC_TIME, "es_ES");
			setlocale(LC_TIME,'spanish');
			$obtener_hora 	= date('H:i:s', time());
			$hora 			= ucfirst(iconv("ISO-8859-1","UTF-8",$obtener_hora));


			$_DATOS_EXCEL[$i]['nombre'] 			= $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
			$_DATOS_EXCEL[$i]['descripcion'] 		= $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
			$_DATOS_EXCEL[$i]['numero_serie'] 		= $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
			$_DATOS_EXCEL[$i]['unidad']      		= $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
			$_DATOS_EXCEL[$i]['id_usuario_alta']	= $_SESSION['id_admin'];
			$_DATOS_EXCEL[$i]['fecha_registro']		= date('Y-m-d');
			$_DATOS_EXCEL[$i]['hora_registro']		= $hora;
			$_DATOS_EXCEL[$i]['id_categoria'] 		= 0;
			$_DATOS_EXCEL[$i]['estatus'] 			= 1;
			$_DATOS_EXCEL[$i]['id_area'] 			= $_SESSION['area'];
		}		
		$errores=0;

		foreach($_DATOS_EXCEL as $campo => $valor){
			$sql = "INSERT INTO inv_productos  (nombre,descripcion,numero_serie,id_unidad,id_usuario_alta,fecha_registro,hora_registro,id_categoria,estatus,id_area)  VALUES ('";
			foreach ($valor as $campo2 => $valor2){
				if($campo2 == "unidad"){
					$unidad = $info -> obtener_unidad($valor2);
					$valor2 = $unidad['id'][0];
				}
				$campo2 == "id_area" ? $sql.= $valor2."');" : $sql.= $valor2."','";
			}

			$result = $ejecucion->ejecuta($sql);
			if (!$result){ 
				echo "Error al insertar registro ".$campo;$errores+=1;
			}else{
				$campus = $info->obtener_todos_almacenes();
				$ccampus = $fn->cuentarray($campus);

				for($i = 0; $i < $ccampus; $i++){
					$qry = "INSERT INTO inv_campus_producto (id_producto, id_campus, cantidad) VALUES ('$result', '{$campus['id'][$i]}','0')";
					$idrel = $ejecucion->ejecuta($qry);
					// foreach($valor as $campo2 => $valor2){
					// 	if($campo2 == 'sku'){
					// 		$qry2 = "UPDATE inv_campus_producto SET cantidad = '$valor2' WHERE id = '$idrel'";
					// 		$ejecucion->ejecuta($qry2);
					// 	}
					// }
				}
			}

			
			

		}	
		/////////////////////////////////////////////////////////////////////////	
		// echo "<hr> <div class='col-xs-12'><div class='form-group'>";
		// echo "<strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong>";
		// echo "</div></div>";
		//Borramos el archivo que esta en el servidor con el prefijo cop_
		unlink($destino);					
		//si por algun motivo no cargo el archivo cop_ 
	}else{
		echo "Primero debes cargar el archivo con extencion .xlsx";
	}
// }

if (isset($action)) {
	$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
}
if (isset($filas)) {
	$columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
}
if (isset($filas)) {
	$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
}