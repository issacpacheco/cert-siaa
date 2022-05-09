<?php
include("class/allClass.php");

use nsalmacen\almacen;
use nsfunciones\funciones;

$infoAlmacen = new almacen();
$fn = new funciones();

//Esta es información para usuarios administradores
$solicitudes    = $infoAlmacen->obtener_solicitudes();
$csolicitudes   = $fn->cuentarray($solicitudes);

$stock          = $infoAlmacen->obtener_materiales_por_agotarse();
$cstock         = $fn->cuentarray($stock);

$prestamos      = $infoAlmacen->obtener_materiales_prestados();
$cprestamos     = $fn->cuentarray($prestamos);

$transfers      = $infoAlmacen->obtener_transferencias_en_curso();
$ctransfers     = $fn->cuentarray($transfers);

//Esta es informacion para los usuarios chofer

$misenvios      = $infoAlmacen->obtener_mis_envios();
$cmisenvios     = $fn->cuentarray($misenvios);

$misenviosfin   = $infoAlmacen->obtener_mis_envios_finalizados();
$cmisenviosfin  = $fn->cuentarray($misenviosfin);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <h2 class="text-center">Panel de Administración</h2>
            </div>
            <div class="panel-body">
                <h1 class="text-center">SISTEMA DE INVENTARIO</h1>
                <hr />
                <?php if($_SESSION['area'] == 1 OR $_SESSION['area'] == 3){ ?>
                <div class="row panel-body">
                    <div class="col-sm-6">
                        <h3 class="text-center">Listado de solicitudes</h3>
                        <div class="panel-body">
                            <div class="left full relative paddingtop15" id="content">
                                <table class="table table-success table-striped" id="tabla1">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Solicitante </th>
                                            <th> Fecha de solicitud </th>
                                            <th> Hora de solicitud </th>
                                            <th> Clave de solicitud </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i = 0,$a=0; $i < $csolicitudes; $i++){ $a = $a+1; ?>
                                        <tr onclick="universalLoad(this)" data-postload="0" data-returnpage="pr-inicio" data-form="" data-page="salida-prestamo-edit" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $solicitudes['clave_solicitud'][$i]; ?>">
                                            <td class="btn-info"><?php echo $a; ?></td>
                                            <td class="btn-info"><?php echo $solicitudes['nombre'][$i]; ?></td>
                                            <td class="btn-info"><?php echo $solicitudes['fecha'][$i]; ?></td>
                                            <td class="btn-info"><?php echo $solicitudes['hora'][$i]; ?></td>
                                            <td class="btn-info"><?php echo $solicitudes['clave_solicitud'][$i]; ?></td>
                                        </tr>
                                    <?php } ?>    
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="text-center">Listado de materiales por agotarse o agotados</h3>
                        <div class="panel-body">
                            <div class="left full fondoblanco relative paddingtop15" id="content">
                                <table class="table table-success table-striped" id="tabla2">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Producto/Material </th>
                                            <th> Cantidad </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i = 0,$a=0; $i < $cstock; $i++){ $a = $a+1; ?>
                                        <tr>
                                            <td class="btn-danger"><?php echo $a; ?></td>
                                            <td class="btn-danger"><?php echo $stock['nombre'][$i]; ?></td>
                                            <td class="btn-danger"><?php echo $stock['cantidad'][$i]; ?></td>
                                        </tr>
                                    <?php } ?>    
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row panel-body">
                    <div class="col-sm-6">
                        <h3 class="text-center">Lista de materiales prestados</h3>
                        <div class="panel-body">
                            <div class="left full fondoblanco relative paddingtop15" id="content">
                                <table class="table table-success table-striped" id="tabla3">
                                    <thead>
                                        <tr>
                                            <th> Solicitante </th>
                                            <th> Material </th>
                                            <th> Fecha/Hora </th>
                                            <th> Clave </th>
                                            <th> Cantidad </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i = 0,$a=0; $i < $cprestamos; $i++){ ?>
                                        <tr>
                                            <td class="btn-warning"><?php echo $prestamos['usuario'][$i]; ?></td>
                                            <td class="btn-warning"><?php echo $prestamos['nombre'][$i]; ?></td>
                                            <td class="btn-warning"><?php echo $prestamos['fecha'][$i].'-/-'.$prestamos['hora'][$i]; ?></td>
                                            <td class="btn-warning"><?php echo $prestamos['clave_solicitud'][$i]; ?></td>
                                            <td class="btn-warning"><?php echo $prestamos['cantidad_prestada'][$i]; ?></td>
                                        </tr>
                                    <?php } ?>    
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="text-center">Transferencias en curso</h3>
                        <div class="panel-body">
                            <div class="left full fondoblanco relative paddingtop15" id="content">
                                <table class="table table-success table-striped" id="tabla4">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Origen </th>
                                            <th> Destino </th>
                                            <th> Clave de envio </th>
                                            <th> Reporte </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i = 0,$a=0; $i < $ctransfers; $i++){ $a = $a+1;  ?>
                                        <tr>
                                            <td class="btn-success"><?php echo $a; ?></td>
                                            <td class="btn-success"><?php echo $transfers['campus_origen'][$i]; ?></td>
                                            <td class="btn-success"><?php echo $transfers['campus_destino'][$i]; ?></td>
                                            <td class="btn-success"><?php echo $transfers['codigo_transfer'][$i]; ?></td>
                                            <td class="text-center btn-success"><i class="btn btn-danger fas fa-file-pdf" onclick="generarreporte('<?php echo $transfers['codigo_transfer'][$i]; ?>');"></i></td>
                                        </tr>
                                    <?php } ?>    
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if($_SESSION['area'] == 4){ ?>
                <div class="row panel-body">
                    <div class="col-sm-6">
                        <h3 class="text-center">Envios asignado</h3>
                        <div class="panel-body">
                            <div class="left full fondoblanco relative paddingtop15" id="content">
                                <table class="table table-success table-striped" id="tabla1">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Origen </th>
                                            <th> Destino </th>
                                            <th> Clave de envio </th>
                                            <th> Reporte </th>
                                            <th> Iniciar viaje </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i = 0,$a=0; $i < $cmisenvios; $i++){ $a = $a+1; ?>
                                        <tr>
                                            <td class="btn-primary"><?php echo $a; ?></td>
                                            <td class="btn-primary"><?php echo $misenvios['campus_origen'][$i]; ?></td>
                                            <td class="btn-primary"><?php echo $misenvios['campus_destino'][$i]; ?></td>
                                            <td class="btn-primary"><?php echo $misenvios['codigo_transfer'][$i]; ?></td>
                                            <td class="text-center btn-primary"><i class="btn btn-danger fas fa-file-pdf" onclick="generarreporte('<?php echo $misenvios['codigo_transfer'][$i]; ?>');"></i></td>
                                            <td class="btn-primary"><input type="button" id="validacion" class="btn btn-info" value="iniciar viaje" onclick="validarviaje('<?php echo $misenvios['codigo_transfer'][$i]; ?>');"></td>
                                        </tr>
                                    <?php } ?>    
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="text-center">Envios Finalizados</h3>
                        <div class="panel-body">
                            <div class="left full fondoblanco relative paddingtop15" id="content">
                                <table class="table table-success table-striped" id="tabla2">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Origen </th>
                                            <th> Destino </th>
                                            <th> Clave de envio </th>
                                            <th> Reporte </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i = 0,$a=0; $i < $cmisenviosfin; $i++){ $a = $a+1; ?>
                                        <tr>
                                            <td class="btn-success"><?php echo $a; ?></td>
                                            <td class="btn-success"><?php echo $misenviosfin['campus_origen'][$i]; ?></td>
                                            <td class="btn-success"><?php echo $misenviosfin['campus_destino'][$i]; ?></td>
                                            <td class="btn-success"><?php echo $misenviosfin['codigo_transfer'][$i]; ?></td>
                                            <td class="text-center btn-success"><i class="btn btn-danger fas fa-file-pdf" onclick="generarreporte('<?php echo $misenvios['codigo_transfer'][$i]; ?>');"></i></td>
                                        </tr>
                                    <?php } ?>    
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
