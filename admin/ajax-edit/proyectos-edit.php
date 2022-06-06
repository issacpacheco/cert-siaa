<?php 
include("../class/allClass.php");

$regresar   = filter_input(INPUT_POST, 'regresar',      FILTER_SANITIZE_SPECIAL_CHARS);
$postload   = filter_input(INPUT_POST, 'returnpage',    FILTER_SANITIZE_SPECIAL_CHARS);
$div        = filter_input(INPUT_POST, 'load',          FILTER_SANITIZE_SPECIAL_CHARS);
$id         = filter_input(INPUT_POST, 'id',            FILTER_SANITIZE_NUMBER_INT);

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$proyecto = $info -> obtener_proyecto($id);
$cproyecto = $fn -> cuentarray($proyecto);

?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Bodeguita <?php echo $proyecto['nombre'][0]; ?>
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>Nombre</label>
                        <div class="form-group">
                            <input type="text" class="form-control validar" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $proyecto['nombre'][0]; ?>">
                        </div>
                    </div>
                </div>
                <div class="left mtop panel-body">
                    <h3 class="left full">Productos/Materiales relacionado con este proyecto:</h3>
                    <table class="table">
                        <thead>
                            <th> ID Material </th>
                            <th> Nombre del material </th>
                            <th> Cantidad </th>
                            <th> Precio </th>
                            <th> Total invertido x material </th>
                        </thead>
                        <tbody>
                            <?php for($i = 0; $i < $cproyecto; $i++){ ?>
                                <tr>
                                    <td><?php echo $proyecto['idmaterial'][$i]; ?></td>
                                    <td><?php echo $proyecto['nombrematerial'][$i]; ?></td>
                                    <td><?php echo $proyecto['total'][$i]; ?></td>
                                    <td>$<?php echo number_format($proyecto['precio'][$i],2,'.',','); ?></td>
                                    <td>$<?php echo number_format($proyecto['totalxmaterial'][$i],2,'.',','); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('bodeguita-edit', 'pr-bodeguitas', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () { 
        $(".dragable").draggable({
            appendTo: "#cajareceptora, #listadoopciones",
            cursor: "move",
            helper: 'move',
            revert: "invalid",
            connectToSortable: "#listadoopciones"
        });  
        
       
       $("#listadoopciones").droppable({
           tolerance: "intersect",
           accept: ".dragable",
           activeClass: "ui-state-default",
           hoverClass: "ui-state-hover",
           drop: function(event, ui) {
               $(this).append($(ui.draggable));
               var id = ui.draggable[0].id;
               eliminarMaterialBod('<?php echo $id; ?>', id);
           }
       });        
        
        $("#cajareceptora").droppable({
            tolerance: "intersect",
            accept: ".dragable",
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            drop: function(event, ui) {        
                $(this).append($(ui.draggable));
                var id = ui.draggable[0].id;
                agregarMaterialBod('<?php echo $id; ?>', id);
            }
        });
    });
</script>