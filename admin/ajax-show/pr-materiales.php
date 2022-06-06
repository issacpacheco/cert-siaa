<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$materiales     = $info->obtener_materiales_categorias();
$cmateriales    = $fn->cuentarray($materiales);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="row panel-heading">
                <div class="col-sm-6">
                    Lista de Materiales/Equipos/etc...
                </div>
                <div class="col-6 mright textright">
                    <?php if($_SESSION['area'] == 6){ ?>
                    <button id="idtest" onclick="openPopup(this, 450, 450)" data-postload="0" data-returnpage="pr-materiales" data-valores="" data-form="" data-page="importacion-productos" data-carpeta="ajax-popup" data-load="board" data-id="" class="btngral botonVerde"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                        <span class="letrablanca font14">Importar Lista</span>
                    </button>
                    <?php } ?>
                    <button id="idtest" onclick="universalLoad(this)" data-postload="0" data-regresar="pr-materiales" data-valores="" data-form="" data-page="materiales-add" data-carpeta="ajax-add" data-load="contenedor" data-id="" class="btngral botonVerde mright"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                        <span class="letrablanca font14">Agregar</span>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="left full fondoblanco relative paddingtop15" id="content">
                    <table class="display fullimportant" id="tabla">
                        <thead>
                            <tr>
                                <th> ID Material </th>
                                <th> Nombre </th>
                                <th> Descripción </th>
                                <th> Cantidad </th>
                                <th> Codigo </th>
                                <th> Categoria </th>
                                <th> Ubicación </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0,$a=0; $i < $cmateriales; $i++){ $a = $a+1;?>
                            <tr onclick="universalLoad(this)" data-postload="0" data-returnpage="pr-materiales" data-form="" data-page="materiales-edit" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $materiales["id"][$i]; ?>">
                                <td><?php echo $materiales['id'][$i]; ?></td>
                                <td><?php echo $materiales['nombre'][$i]; ?></td>
                                <td><?php echo $materiales['descripcion'][$i]; ?></td>
                                <td><?php echo $materiales['cantidad'][$i]; ?> - <?php echo $materiales['unidad'][$i] ?></td>
                                <td><?php echo $materiales['numero_serie'][$i]; ?></td>
                                <td><?php echo $materiales['categoria'][$i]; ?></td>
                                <td><?php echo $materiales['bodega'][$i]; ?></td>
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