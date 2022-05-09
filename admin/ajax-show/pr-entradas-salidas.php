<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info        = new almacen();
$fn          = new funciones();

$entradas    = $info  -> obtener_entradas();
$centradas   = $fn    -> cuentarray($entradas);

$salidas     = $info  -> obtener_salidas();
$csalidas    = $fn    -> cuentarray($salidas);


?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="row panel-heading">
                <div class="col-sm-6">
                    Listado de entradas y salidas de materiales/equipos/etc...
                </div>
                <div class="col-6 mright textright">
                    <button id="idtest" onclick="universalLoad(this)" data-postload="0" data-regresar="pr-entradas-salidas" data-valores="" data-form="" data-page="entrada-add" data-carpeta="ajax-add" data-load="contenedor" data-id="" class="btngral botonVerde mright"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                        <span class="letrablanca font14">Agregar Entrada</span>
                    </button> 
                </div>
            </div>
            <div class="panel-body">
                <div class="left full fondoblanco relative paddingtop15" id="content">
                    <table class="display fullimportant" id="tablaentradas">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Material/Equipo/Etc... </th>
                                <th> Cantidad </th>
                                <th> Fecha y Hora </th>
                                <th> Usuario que realizo la acción </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0,$a=0; $i < $centradas; $i++){ $a = $a+1;?>
                            <tr>
                                <td><?php echo $a; ?></td>
                                <td><?php echo $entradas['producto'][$i]; ?></td>
                                <td><?php echo $entradas['cantidad'][$i]; ?></td>
                                <td><?php echo $entradas['fecha'][$i].' -/- '.$entradas['hora'][$i] ?></td>
                                <td><?php echo $entradas['nombre'][$i]; ?></td>
                            </tr>
                        <?php } ?>    
                        </tbody>    
                    </table>
                </div>
            </div>
            <div class="row panel-heading">
                <div class="col-sm-6">
                </div>
                <div class="col-6 mright textright">
                    <button id="idtest" onclick="universalLoad(this)" data-postload="0" data-regresar="pr-entradas-salidas" data-valores="" data-form="" data-page="salida-add" data-carpeta="ajax-add" data-load="contenedor" data-id="" class="btngral botonVerde mright"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                        <span class="letrablanca font14">Agregar Salida</span>
                    </button> 
                </div>
            </div>
            <div class="panel-body">
                <div class="left full fondoblanco relative paddingtop15" id="content">
                    <table class="display fullimportant" id="tablasalidas">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Material/Equipo/Etc... </th>
                                <th> Cantidad </th>
                                <th> Fecha y Hora </th>
                                <th> Usuario que realizo la acción </th>
                                <th> Codigo de prestamo </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0,$a=0; $i < $csalidas; $i++){ $a = $a+1;?>
                            <tr>
                                <td><?php echo $a; ?></td>
                                <td><?php echo $salidas['producto'][$i]; ?></td>
                                <td><?php echo $salidas['cantidad'][$i]; ?></td>
                                <td><?php echo $salidas['fecha'][$i].' -/- '.$salidas['hora'][$i] ?></td>
                                <td><?php echo $salidas['nombre'][$i]; ?></td>
                                <td><?php echo $salidas['clave_solicitud'][$i]; ?></td>
                            </tr>
                        <?php } ?>    
                        </tbody>    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>    
    $(document).ready(function () {
        var t = $('#tablaentradas').DataTable({
            "scrollX": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontró ningún registro",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros",
                "search": "Buscar",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
        var t = $('#tablasalidas').DataTable({
            "scrollX": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontró ningún registro",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros",
                "search": "Buscar",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
    });    
</script>