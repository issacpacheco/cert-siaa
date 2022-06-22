<?php
include('../class/allClass.php');

use nsusuarios\usuarios;
use nsfunciones\funciones;

$info   = new usuarios();
$fn     = new funciones();

$grupos = $info->obtener_grupos();
$cgrupos = $fn->cuentarray($grupos);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                Grupos de usuarios
            </div>
            <div class="col-6 mright textright">
                <button id="idtest" onclick="openPopup(this, 450, 350)" data-postload="0" data-returnpage="pr-grupos" data-valores="" data-form="" data-page="grupo-add" data-carpeta="ajax-popup" data-load="board" data-id="" class="btngral botonVerde"><span class="fas fa-plus-circle font16"></span><span class="letrablanca font14">
                    <span class="letrablanca font14">Agregar Grupo</span>
                </button> 
            </div>
            <div class="panel-body">
                <div class="left full fondoblanco relative paddingtop15" id="content">
                    <table class="display fullimportant" id="tabla">
                        <thead>
                            <tr>
                                <th> Nombre </th>
                                <?php if($_SESSION['nivel'] != 99){ ?>
                                <th> Descripción </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0; $i < $cgrupos; $i++){ ?>
                            <tr onclick="openPopupEdit(this, 450, 450)" data-postload="0" data-returnpage="pr-grupos" data-form="" data-page="grupo-edit" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $grupos["id"][$i]; ?>">
                                <td><?php echo $grupos['nombre'][$i]; ?></td>
                                <?php if($_SESSION['nivel'] != 99){ ?>
                                <td><?php echo $grupos['descripcion'][$i]; ?></td>
                                <?php } ?>
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