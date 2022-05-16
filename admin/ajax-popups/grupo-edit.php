<?php
include("../class/allClass.php");

$postload = filter_input(INPUT_POST, 'returnpage', FILTER_SANITIZE_SPECIAL_CHARS);
$div = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

use nsusuarios\usuarios;
use nsfunciones\funciones;

$info   = new usuarios();
$fn     = new funciones();

$grupo = $info->obtener_subarea($id);
?>



<div class="popup-header left full">
    <h1 class="left full titulopopup">Agregar grupo o subarea <?php echo $grupo['nombre'][0] ?></h1>
</div>
<div class="popup-body left full">
    <form name="frmPopup" id="frmPopup">
        <input type="hidden" name="id" value="<?php echo $grupo['id'][0]; ?>">
        <div class="left col12 small12 padding5">
            <label class="left full mtop">Nombre de la categoria</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $grupo['nombre'][0]; ?>" class="form-control left full validar">
        </div>
        <div class="left col12 small12 padding5">
            <label class="left full mtop">Nombre de la categoria</label>
            <textarea name="descripcion" id="descripcion" cols="55" rows="10"><?php echo $grupo['descripcion'][0]; ?></textarea>
        </div>
    </form>

</div>

<div class="popup-footer">
    <button type="button" class="btngral btnRegresar right mright" onclick="editPopup(this)" data-page="grupo-edit" data-load="<?php echo $postload; ?>" data-div="<?php echo $div; ?>" data-id="<?php echo $id ?>">Guardar</button>
    <button type="button" class="btngral btnCancelar right mright" onclick="cerrarpopup()">Cancelar</button>
