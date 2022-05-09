<?php 
include('../class/allClass.php');
$regresar   = filter_input(INPUT_POST, 'regresar',      FILTER_SANITIZE_STRING);
$postload   = filter_input(INPUT_POST, 'returnpage',    FILTER_SANITIZE_STRING);
$div        = filter_input(INPUT_POST, 'load',          FILTER_SANITIZE_STRING);
$folio = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$prestamos   = $info -> obtener_prestamos($folio);
$cprestamos  = $fn   -> cuentarray($prestamos);
?>
<form id="frmRegistro">
<?php for($i = 0; $i < $cprestamos; $i++){ ?>
    <input type="hidden" name="idsalida[]" value="<?php echo $prestamos['id'][$i] ?>">
    <input type="hidden" name="producto[]" value="<?php echo $prestamos['id_producto'][$i] ?>">
    <input type="hidden" name="idsolicitante" value="<?php echo $prestamos['id_solicitante'][$i] ?>">
    <div class="form-wrapper col-sm-3">
        <label>Material/Equipo Prestado</label>
        <div class="form-group">
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre" value="<?php echo $prestamos['producto'][$i]; ?>" readonly>
        </div>
    </div>
    <div class="form-wrapper col-sm-3">
        <label>Cantidad Solicitada
        </label>
        <div class="form-group">
            <input type="text" class="form-control esnumero" name="" id="cantidad" placeholder="Cantidad" value="<?php echo $prestamos['cantidad_prestada'][$i]; ?>" readonly>
        </div>
    </div>
    <div class="form-wrapper col-sm-3">
        <label>Cantidad a prestar</label>
        <div class="form-group">
            <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad" placeholder="Cantidad" value="" autocomplete="FALSE">
        </div>
    </div>
    <div class="form-wrapper col-sm-3">
        <label>Estado del prestamo</label>
        <div class="form-group">
            <select name="estatus[]" id="estatus" class="form-control validar">
                <option value="0">Selecciona un estatus</option>
                <option value="3">Prestar</option>
                <option value="5">No disponible</option>
            </select>
        </div>
    </div>

<?php } ?>
<div class="mright textright">
        <button type="button" class="btnRegresar right btngral" onclick="saveInfo('salida-prestamo-edit', 'pr-entradas-salidas', this);">
            <span class="letrablanca font14">Guardar</span>
        </button>
    </div>
</form>