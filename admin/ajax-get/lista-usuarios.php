<?php 
include('../class/allClass.php');

use nsusuarios\usuarios;
use nsfunciones\funciones;

$info   = new usuarios();
$fn     = new funciones();

$usuarios   = $info -> obtener_usuarios();
$cusuarios  = $fn   -> cuentarray($usuarios);

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
