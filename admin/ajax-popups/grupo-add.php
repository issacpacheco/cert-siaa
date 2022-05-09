<?php
include("../class/allClass.php");

$postload = filter_input(INPUT_POST, 'returnpage', FILTER_SANITIZE_STRING);
$div = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_STRING);

$regresar = filter_input(INPUT_POST, 'regresar', FILTER_SANITIZE_STRING);
$div = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_STRING);

?>



<div class="popup-header left full">
    <h1 class="left full titulopopup">Agregar grupo</h1>
</div>
<div class="popup-body left full">
    <form name="frmPopup" id="frmPopup">
        <div class="left col12 small12 padding5">
            <label class="left full mtop">Nombre del grupo</label>
            <input type="text" id="nombre" name="nombre" value="" class="form-control left full validar">
        </div>
    </form>

</div>

<div class="popup-footer">
    <button type="button" class="btngral btnRegresar right mright" onclick="savePopup(this)" data-page="grupo-add" data-load="<?php echo $postload; ?>" data-div="<?php echo $div; ?>">Guardar</button>
    <button type="button" class="btngral btnCancelar right mright" onclick="cerrarpopup()">Cancelar</button>
