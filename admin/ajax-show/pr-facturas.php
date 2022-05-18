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
                    <h1>Facturas</h1>
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
                            <tr onclick="universalLoad(this)" data-postload="0" data-returnpage="pr-facturas" data-form="" data-page="facturas-edit" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $facturas["factura"][$i]; ?>">
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