<?php
include("../../class/allClass.php");
use nsalmacen\almacen;
use nsfunciones\funciones;

$info       = new almacen();
$fn         = new funciones();
$clave      = filter_input(INPUT_GET, 'clave', FILTER_SANITIZE_SPECIAL_CHARS);
$lista      = $info ->obtener_lista_transferencia($clave);
$clista     = $fn   ->cuentarray($lista);

// $cliente = "Luis Cabrera Benito";
// $remitente = "Luis Cabrera Benito";
$origen = $lista['campus_origen'][0];
$destino = $lista['campus_destino'][0];
// $web = "https://parzibyte.me/blog";
$mensajePie = "CENTRO EDUCATIVO RODRIGUEZ TAMAYO";



$fecha = date("Y-m-d");
require_once '../../../includes/dompdf/lib/html5lib/Parser.php';
require_once '../../../includes/dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once '../../../includes/dompdf/lib/php-svg-lib/src/autoload.php';
require_once '../../../includes/dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();


$html = "<!DOCTYPE html>
<html lang='es'>
<head>
    <!--<link rel='stylesheet' href='./bs3.min.css'>-->
    <link rel='stylesheet' href='../../addons/bootstrap/css/bootstrap.css'/>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Formato de transferecia</title>
</head>
<body>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-10 '>
                <h1>Transferencia</h1>
            </div>
            <div class='col-xs-2'>
                <img class='img img-responsive' src='../../images/backgrounds/logo.png' alt='Logotipo'>
            </div>
        </div>
        <hr>
        <div class='row'>
            <div class='col-xs-10'>
                <h1 class='h5'><strong>Responsable de envio: </strong>".$lista['nombre'][0]."</h1>
                <h1 class='h5'><strong>Viaje: </strong>".$origen."-".$destino."</h1>
                <h1 class='h5'><strong>Fecha: </strong>".$fecha."</h1>
                <h1 class='h5'><strong>Codigo de transferencia: </strong>".$clave."</h1>
            </div>
            <div class='col-xs-2 text-center'>
            </div>
        </div>
        <hr>
        <div class='row text-center' style='margin-bottom: 2rem;'>
            <div class='col-xs-6'>
                <h1 class='h2'>Almacen de origen</h1>
                <strong class='h3'>".$origen."</strong>
            </div>
            <div class='col-xs-6'>
                <h1 class='h2'>Almacen de destino</h1>
                <strong class='h3'>".$destino."</strong>
            </div>
        </div>
        <div class='row'>
            <div class='col-xs-12'>
                <table class='table table-condensed table-bordered table-striped'>
                    <thead>
                    <tr>
                        <th>Material/Equipo</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>";
                    for($i = 0; $i < $clista; $i++){
                        $html .= "<tr>
                            <td>".$lista["producto"][$i]."</td>
                            <td>".$lista["cantidad"][$i]."</td>
                        </tr>";
                    }
                    $html .= "</tbody>
                </table>
            </div>
        </div>
        <div class='row' style='margin-top:50px;'>
            <div class='col-xs-6'>
                <p>____________________________________</p>
                <h6 class='text-center'>Firma de entregado</h6>
            </div>
            <div class='col-xs-6'>
                <p>____________________________________</p>
                <h6 class='text-center'>Firma de entregado</h6>
            </div>
        </div>
        <div class='row'>
            <div class='col-xs-12 text-center'>
                <p class='h5'>".$mensajePie."</p>
            </div>
        </div>
    </div>
</body>
</html>";
$newfile = "../../pdf/transferencias/reporte-transferencia-".$clave.".pdf";

// include("../../../includes/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isRemoteEnabled', TRUE);
$options->set('debugKeepTemp', TRUE);
$options->set('isHtml5ParserEnabled', TRUE);
$options->set('chroot', '/');
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');
//$dompdf->set_paper(array(0,0,500,1000));

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream($newfile);
file_put_contents($newfile, $dompdf->output()); 
$dompdf->stream($newfile);
