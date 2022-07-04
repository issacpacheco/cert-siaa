<?php
include("../class/allClass.php");

$postload = filter_input(INPUT_POST, 'returnpage', FILTER_SANITIZE_SPECIAL_CHARS);
$div = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();


$materiales     = $info -> obtener_materiales_salida();
$cmateriales    = $fn   -> cuentarray($materiales);

?>
<style>
    .zindex10000{
        width: 100% !important;
        z-index: 10000;
    }
</style>


<div class="popup-header left full">
    <h1 class="left full titulopopup">Agregar Aula/Departamento</h1>
</div>
<div class="popup-body left full">
    <form name="frmPopup" id="frmPopup">
        <input type="hidden" name="id_departamento" id="id_departamento" value="<?php echo $id; ?>">
        <div class="left col12 small12 padding5">
            <label>Selecciona material/producto</label>
            <div class="form-group">
                <select name="producto[]" id="producto" class="form-control js-example-basic-single">
                    <option value="">Selecciona un material/producto</option>
                    <?php for($i = 0; $i < $cmateriales; $i++){ ?>
                    <option value="<?php echo $materiales['id'][$i]; ?>"><?php echo $materiales['nombre'][$i]; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="left col12 small12 padding5">
            <label>Cantidad de salida</label>
            <div class="form-group">
                <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad" placeholder="Cantidad" value="" autocomplete="FALSE">
            </div>
        </div>
    </form>

</div>

<div class="popup-footer">
    <button type="button" class="btngral btnRegresar right mright" onclick="savePopup(this)" data-page="material-departameto-salida" data-load="<?php echo $postload; ?>" data-div="<?php echo $div; ?>">Guardar</button>
    <button type="button" class="btngral btnCancelar right mright" onclick="cerrarpopup()">Cancelar</button>
    <script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        // $('.select2-container').addClass("zindex10000");
    });
    </script>