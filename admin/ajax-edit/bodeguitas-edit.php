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

$bodega                 = $info     -> obtener_bodega($id);
$materialsinbod         = $info     -> obtener_material_sin_bodeguita();
$cmaterialsinbod        = $fn       -> cuentarray($materialsinbod);

$materialesasignados    = $info     -> material_con_bodega($id);
$cmaterialesasignados   = $fn       -> cuentarray($materialesasignados);

?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Bodeguita <?php echo $bodega['nombre'][0]; ?>
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <input type="hidden" name="id_categoria" id="id_categoria" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>Nombre</label>
                        <div class="form-group">
                            <input type="text" class="form-control validar" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $bodega['nombre'][0]; ?>">
                        </div>
                    </div>
                </div>
                <div class="left mtop panel-body">
                    <h3 class="left full">Productos/Materiales relacionado con esta categoria:</h3>
                    <div class="let full mbottom10">
                        <label class="left full">Filtrar listado: </label>
                        <input type="text" name="" class="left col2 small12" onkeyup="filtrarportexto(value)" />
                    </div>
                    
                    
                    <div class="left full mtop20">
                        <div class="col9 left">
                            <p class="left full letraroja">Materiales disponibles para asignar a esta categoria:</p>
                            <div class="left full" id="listadoopciones">
                                <?php for($i=0; $i<$cmaterialsinbod; $i++){ ?>
                                    <div class="opcionsitios table full dragable" rel="<?php echo $materialsinbod["nombre"][$i]; ?> <?php echo $materialsinbod["id"][$i]; ?>" id="<?php echo $materialsinbod["id"][$i]; ?>"><span class="tablecell"><b><?php echo $materialsinbod["nombre"][$i]; ?></b><i>(<?php echo $materialsinbod["descripcion"][$i]; ?>)</i></span></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="col9 paddingleft15 left">
                            <p class="left full letraroja">Arrastre aquí los materiales para asignarlo a esta categoria:</p>
                            <div class="left full" id="cajareceptora">
                                <?php if($cmaterialesasignados > 0){ for($i=0; $i<$cmaterialesasignados; $i++){ ?>
                                    <div class="table full dragable" id="<?php echo $materialesasignados["id"][$i]; ?>"><span class="tablecell"><b><?php echo $materialesasignados["nombre"][$i]; ?></b><i>(<?php echo $materialesasignados["descripcion"][$i]; ?>)</i></span></div>
                                <?php }} ?>
                            </div>
                        </div>                
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('categoria-edit', 'pr-categorias', this);">
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