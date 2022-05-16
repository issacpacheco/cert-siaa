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
<label>Lista de usuarios</label>
<div class="form-group">
    <select name="idusuario" id="idusuario" class="form-control">
        <option value="">Selecciona un usuario</option>
        <?php for($i = 0; $i < $cusuarios; $i++){ ?>
        <option value="<?php echo $usuarios['id'][$i]; ?>"><?php echo $usuarios['nombre'][$i]; ?></option>
        <?php } ?>
    </select>
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