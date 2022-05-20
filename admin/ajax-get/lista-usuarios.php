<?php 
include('../class/allClass.php');

$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);

use nsusuarios\usuarios;
use nsfunciones\funciones;

$info   = new usuarios();
$fn     = new funciones();

$usuarios   = $info -> obtener_usuarios();
$cusuarios  = $fn   -> cuentarray($usuarios);

$grupos   = $info -> obtener_grupos();
$cgrupos  = $fn   -> cuentarray($grupos);

if($tipo == 1){
?>
<div class="col-sm-4">
    <label>Lista de usuarios</label>
    <div class="form-group">
        <select name="idusuario" id="idusuario" class="form-control">
            <option value="">Selecciona un usuario</option>
            <?php for($i = 0; $i < $cusuarios; $i++){ ?>
            <option value="<?php echo $usuarios['id'][$i]; ?>"><?php echo $usuarios['nombre'][$i]; ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="col-sm-8">
    <label>¿La persona que buscas no esta en la lista?</label>
    <div class="form-group">
        NO <input type="checkbox" class="" name="listavacia" id="listavacia" value="1">
    </div>
</div>

<div class="row oculto" id="formularionuevousuario">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" name="nombrenuevousuario" id="nombrenuevousuario" class="form-control" value="" placeholder="Nombre">
        </div>
    </div>
    <div class="col-sm-12">
        <label>¿Es docente o administrativo?</label>
        <div class="form-group">
            SI <input type="checkbox" class="" name="validacionadmin" id="validacionadmin" value="1">
        </div>
    </div>
    <div class="" id="estudiantes">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="">Grado</label>
                <input type="text" name="grado" id="grado" class="form-control" value="" placeholder="grado">
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="">Grupo</label>
                <input type="text" name="grupo" id="grupo" class="form-control" value="" placeholder="grupo">
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="">Carrera</label>
                <input type="text" name="carrera" id="carrera" class="form-control" value="" placeholder="carrera">
            </div>
        </div>
    </div>
</div>

<?php }else if($tipo == 2){ ?>
<label>Lista de usuarios</label>
<div class="form-group">
    <select name="idgrupo" id="idgrupo" class="form-control">
        <option value="">Selecciona un grupo</option>
        <?php for($i = 0; $i < $cgrupos; $i++){ ?>
        <option value="<?php echo $grupos['id'][$i]; ?>"><?php echo $grupos['nombre'][$i]; ?></option>
        <?php } ?>
    </select>
</div>
<?php } ?>