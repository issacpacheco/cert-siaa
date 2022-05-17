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

$categoria              = $info     -> obtener_categoria($id);
$materialsincat         = $info     -> obtener_materiales_sin_categorias();
$cmaterialsincat        = $fn       -> cuentarray($materialsincat);

$materialesasignados    = $info     -> material_asignado($id);
$cmaterialesasignados   = $fn       -> cuentarray($materialesasignados);
var_dump($cmaterialesasignados);

?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Agregar Material/Producto/Equipo/Etc...
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <input type="hidden" name="id_material" id="id_material" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>Nombre</label>
                        <div class="form-group">
                            <input type="text" class="form-control validar" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $categoria['nombre'][0]; ?>">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Estatus</label>
                        <div class="form-group">
                            <select name="estatus" id="estatus" class="form-control">
                                <option value="2" selected>Selecciona un estatus</option>
                                <option value="1" <?php if($material['estatus'][0] == 1){ echo "selected"; }?>>Activo</option>
                                <option value="0" <?php if($material['estatus'][0] == 0){ echo "selected"; }?>>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="left full mtop paddingbottom15">
                    <h1 class="left full">Productos/Materiales relacionado con esta categoria:</h1>  
                    <div class="let full mbottom10">
                        <label class="left full">Filtrar listado: </label>
                        <input type="text" name="" class="left col2 small12" onkeyup="filtrarportexto(value)" />
                    </div>
                    
                    
                    <div class="left full mtop20">
                        <div class="col9 left">
                            <p class="left full letraroja">Materiales disponibles:</p>
                            <div class="left full" id="listadoopciones">
                                <?php for($i=0; $i<$cmaterialsincat; $i++){ ?>
                                    <div class="opcionsitios table full dragable" rel="<?php echo $materialsincat["nombre"][$i]; ?> <?php echo $materialsincat["id"][$i]; ?>" id="<?php echo $materialsincat["id"][$i]; ?>"><span class="tablecell"><b><?php echo $materialsincat["nombre"][$i]; ?></b><i>(<?php echo $materialsincat["id"][$i]; ?>)</i></span></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="col9 paddingleft15 left">
                            <p class="left full letraroja">Arrastre aquí los materiales para asignarlo a esta categoria categoria:</p>
                            <div class="left full" id="cajareceptora">
                                <?php if($cmaterialesasignados > 0){ for($i=0; $i<$cmaterialesasignados; $i++){ ?>
                                    <div class="table full dragable" id="<?php echo $materialesasignados["id"][$i]; ?>"><span class="tablecell"><b><?php echo $materialesasignados["nombre"][$i]; ?></b><i>(<?php echo $materialesasignados["id_categoria"][$i]; ?>)</i></span></div>
                                <?php }} ?>
                            </div>
                        </div>                
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('materiales-edit', 'pr-materiales', this);">
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
               eliminarMaterial('<?php echo $id; ?>', id);
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
                agregarMaterial('<?php echo $id; ?>', id);
            }
        });
    });
</script>