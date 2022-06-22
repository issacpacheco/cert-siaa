<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info        = new almacen();
$fn          = new funciones();

$entradas    = $info  -> obtener_entradas_transferencia();
$centradas   = $fn    -> cuentarray($entradas);

$salidas     = $info  -> obtener_salidas_transferencia();
$csalidas    = $fn    -> cuentarray($salidas);


?>
<style>
    .swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal{
            margin: auto;
            width: 50%;
        }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="row panel-heading">
                <div class="col-sm-6">
                </div>
                <div class="col-6 mright textright">
                    <button id="idtest" onclick="universalLoad(this)" data-postload="0" data-regresar="pr-transferencia" data-valores="" data-form="" data-page="transferencia-salida-add" data-carpeta="ajax-add" data-load="contenedor" data-id="" class="btngral botonVerde mright"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                        <span class="letrablanca font14">Agregar Transferencia de Salida</span>
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
                                <th> Folio </th>
                                <th> Reporte </th>
                                <?php for($i = 0,$a=0; $i < $csalidas; $i++){?>
                                <?php if($salidas['estatus'][$i] !== '4'){ ?>
                                <th> Cancelar transferencia </th>
                                <?php }} ?>
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
                                <td><?php echo $salidas['codigo_transfer'][$i]; ?></td>
                                <td class="text-center"><i class="btn btn-danger fas fa-file-pdf" onclick="generarreporte('<?php echo $salidas['codigo_transfer'][$i]; ?>');"></i></td>
                                <?php if($salidas['estatus'][$i] !== '4'){ ?>
                                <td class="text-center"><i class="btn btn-danger fas fa-times-circle" onclick="cancelartransferencia('<?php echo $salidas['codigo_transfer'][$i]; ?>');"> <span>Cancelar transferencia</span></i></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>    
                        </tbody>    
                    </table>
                </div>
            </div>
            <div class="row panel-heading">
                <div class="col-sm-6">
                    Transferencias
                </div>
                <div class="col-6 mright textright">
                    <button id="idtest" onclick="universalLoad(this)" data-postload="0" data-regresar="pr-transferencia" data-valores="" data-form="" data-page="transferencia-entrada-add" data-carpeta="ajax-add" data-load="contenedor" data-id="" class="btngral botonVerde mright"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                        <span class="letrablanca font14">Agregar Transferencia de Entrada</span>
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
        </div>
    </div>
</div>
<script>    
    $(document).ready(function () {
        var t = $('#tablaentradas').DataTable({
            "scrollX": true,
            "stateSave": true,
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
            "stateSave": true,
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
    function generarreporte(clave){
        window.location.href = "../admin/upload/pdf/reportes-transferencia.php?clave="+clave;
    }
    function cancelartransferencia(clave){
        var postpagina = "pr-transferencia";
        Swal.fire({
            title: '¿Estas seguro de cancelar la transferencia?',
            text: "Esta acción no se podra corregir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro',
            cancelButtonText: 'No, cancela la acción'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'ajax-delete/cancelartransferencia',
                    data: {folio:clave},
                    success: function(response){
                        alertaVerde('Se elimino la transferencia con exito!');
                        simpleload('contenedor', postpagina);
                    }
                });
                Swal.fire(
                'Eliminado!',
                'La transferencia ha sido cancelado con exito!',
                'success'
                )
            }
        })
        
    }
</script>