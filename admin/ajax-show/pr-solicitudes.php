<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$solicitudes     = $info->obtener_mis_solicitudes();
$csolicitudes    = $fn->cuentarray($solicitudes);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="row panel-heading">
                <div class="col-sm-6">
                    Lista de Solicitudes
                </div>
                <div class="col-6 mright textright">
                    <button id="idtest" onclick="universalLoad(this)" data-postload="0" data-regresar="pr-solicitudes" data-valores="" data-form="" data-page="solicitud-add" data-carpeta="ajax-add" data-load="contenedor" data-id="" class="btngral botonVerde mright"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                        <span class="letrablanca font14">Agregar</span>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="left full fondoblanco relative paddingtop15" id="content">
                    <table class="display fullimportant" id="tabla">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Fecha de solicitud </th>
                                <th> Hora de solicitud </th>
                                <th> Clave de solicitud </th>
                                <th> Estatus </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0,$a=0; $i < $csolicitudes; $i++){ $a = $a+1; 
                            switch($solicitudes['estatus'][$i]){
                                case '1':
                                    $estatus = "SOLICITADO";
                                    $clase = "btn-info";
                                break;
                                case '2':
                                    $estatus = "EN REVISIÓN";
                                    $clase = "btn-warning";
                                break;
                                case '3':
                                    $estatus = "ACEPTADO";
                                    $clase = "btn-success";
                                break;
                                case '4':
                                    $estatus = "DEVOLUCION INCOMPLETA";
                                    $clase = "btn-danger";
                                break;
                                case '5':
                                    $estatus = "DEVOLUCIÓN COMPLETA";
                                    $clase = "btn-primary";
                                break;
                            }
                        ?>
                            <tr onclick="openPopupEdit(this, 500, 900)" data-postload="0" data-returnpage="pr-solicitudes" data-form="" data-page="solicitud-edit" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $solicitudes["clave_solicitud"][$i]; ?>">
                                <td class="<?php echo $clase; ?>"><?php echo $a; ?></td>
                                <td class="<?php echo $clase; ?>"><?php echo $solicitudes['fecha'][$i]; ?></td>
                                <td class="<?php echo $clase; ?>"><?php echo $solicitudes['hora'][$i]; ?></td>
                                <td class="<?php echo $clase; ?>"><?php echo $solicitudes['clave_solicitud'][$i]; ?></td>
                                <td class="<?php echo $clase; ?>"><?php echo $estatus; ?></td>
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
        var t = $('#tabla').DataTable({
            "scrollX": true,
            "stateSave": true,
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