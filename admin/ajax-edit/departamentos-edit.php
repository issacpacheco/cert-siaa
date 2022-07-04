<?php
include('../class/allClass.php');

$regresar   = filter_input(INPUT_POST, 'regresar',      FILTER_SANITIZE_SPECIAL_CHARS);
$postload   = filter_input(INPUT_POST, 'returnpage',    FILTER_SANITIZE_SPECIAL_CHARS);
$div        = filter_input(INPUT_POST, 'load',          FILTER_SANITIZE_SPECIAL_CHARS);
$id         = filter_input(INPUT_POST, 'id',            FILTER_SANITIZE_NUMBER_INT);

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$materiales     = $info->obtener_materiales_departamento($id);
$cmateriales    = $fn->cuentarray($materiales);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="row panel-heading">
                <div class="col-sm-6">
                    Lista de materiales de este Departamento o Aula
                </div>
                <div class="col-6 mright textright">
                    <button id="idtest" onclick="openPopupEdit(this, 400, 350)" data-postload="0" data-returnpage="departamentos-edit" data-valores="" data-form="" data-page="material-departamento-add" data-carpeta="ajax-popup" data-load="board" data-id="<?php echo $id; ?>" data-div="contenedor" class="btngral botonVerde"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
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
                                <th> Nombre </th>
                                <th> Cantidad </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0,$a=0; $i < $cmateriales; $i++){ $a = $a+1;?>
                            <tr>
                                <td><?php echo $a; ?></td>
                                <td><?php echo $materiales['nombrematerial'][$i]; ?></td>
                                <td><?php echo $materiales['total'][$i]; ?></td>
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