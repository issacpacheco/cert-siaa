<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$facturas     = $info->obtener_facturas();
$cfacturas    = $fn->cuentarray($facturas);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="row panel-heading">
                <div class="col-sm-6">
                    Bodeguitas
                </div>
                <div class="col-6 mright textright">
                    <button id="idtest" onclick="openPopup(this, 400, 350)" data-postload="0" data-returnpage="pr-bodeguitas" data-valores="" data-form="" data-page="bodeguitas-add" data-carpeta="ajax-popup" data-load="board" data-id="" class="btngral botonVerde"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
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
                                <th> Factura </th>
                                <th> Fecha </th>
                                <th> Hora </th>
                                <th> Comentarios </th>
                                <th> Quien realizo la acción </th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0,$a=0; $i < $cfacturas; $i++){ $a = $a+1;?>
                            <tr onclick="openPopupEdit(this, 300, 250)" data-postload="0" data-returnpage="pr-bodeguitas" data-form="" data-page="bodeguitas-edit" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $facturas["id"][$i]; ?>">
                                <td><?php echo $a; ?></td>
                                <td><?php echo $facturas['factura'][$i]; ?></td>
                                <td><?php echo $facturas['fecha'][$i]; ?></td>
                                <td><?php echo $facturas['hora'][$i]; ?></td>
                                <td><?php echo $facturas['comentarios'][$i]; ?></td>
                                <td><?php echo $facturas['usuario'][$i]; ?></td>
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