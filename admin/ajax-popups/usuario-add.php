<?php
include("../class/allClass.php");
use nsalmacen\almacen;
use nsusuarios\usuarios;
use nsfunciones\funciones;

$almacen    = new almacen();
$usuarios   = new usuarios();
$fn         = new funciones();

$postload   = filter_input(INPUT_POST, 'returnpage', FILTER_SANITIZE_STRING);
$div        = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_STRING);

$regresar   = filter_input(INPUT_POST, 'regresar', FILTER_SANITIZE_STRING);
$div        = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_STRING);

$niveles    = $usuarios -> nivelesusuarios();
$cniveles   = $fn       -> cuentarray($niveles);

$subareas   = $almacen  -> subareas();
$csubareas  = $fn       -> cuentarray($subareas);

?>



<div class="popup-header left full">
    <h1 class="left full titulopopup">Agregar categoria</h1>
</div>
<div class="popup-body left full">
    <form name="frmPopup" id="frmPopup">
        <div class="left col12 small12 padding5">
            <label class="left full mtop">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="" class="form-control left full validar" autocomplete="nope">
            <label class="left full mtop">Area</label>
            <select name="subarea" id="subarea" class="form-control left full">
                <?php for($i = 0; $i < $csubareas; $i++){ ?>
                    <option value="<?php echo $subareas['id'][$i] ?>"><?php echo $subareas['nombre'][$i] ?></option>
                <?php } ?>
            </select>
            <label class="left full mtop">Nivel de usuario</label>
            <select name="niveles" id="niveles" class="form-control left full">
                <?php for($i = 0; $i < $cniveles; $i++){ ?>
                    <option value="<?php echo $niveles['id'][$i] ?>"><?php echo $niveles['nombre'][$i] ?></option>
                <?php } ?>
            </select>
            <label class="left full mtop">Usuario</label>
            <input type="text" id="usuario" name="usuario" value="" class="form-control left full validar" autocomplete="nope">
            <label class="left full mtop">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" value="" class="form-control left full validar" autocomplete="nope">
            <label class="left full mtop">Confirma contraseña</label>
            <input type="password" id="val_contrasena" name="val_contrasena" value="" class="form-control left full validar">
            <input type="checkbox" id="mostrar_contrasena" name="mostrar_contrasena" value="" class=""> Ver contraseña
        </div>
    </form>

</div>

<div class="popup-footer">
    <button type="button" class="btngral btnRegresar right mright" onclick="savePopup(this)" data-page="usuario-add" data-load="<?php echo $postload; ?>" data-div="<?php echo $div; ?>">Guardar</button>
    <button type="button" class="btngral btnCancelar right mright" onclick="cerrarpopup()">Cancelar</button>
<script>
        $(document).ready(function () {
            $('#mostrar_contrasena').click(function () {
                if ($('#mostrar_contrasena').is(':checked')) {
                    $('#contrasena').attr('type', 'text');
                    $('#val_contrasena').attr('type', 'text');
                } else {
                    $('#contrasena').attr('type', 'password');
                    $('#val_contrasena').attr('type', 'password');
                }
            });
        });
    </script>