<?php 
include('../class/allClass.php');

$folio = filter_input(INPUT_POST, 'folio', FILTER_SANITIZE_SPECIAL_CHARS);
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$tranferencia   = $info -> obtener_transferencia($folio);
$ctranferencia  = $fn   -> cuentarray($tranferencia);

for($i = 0; $i < $ctranferencia; $i++){

?>

<input type="hidden" name="producto[]" value="<?php echo $tranferencia['id_producto'][$i] ?>">
<input type="hidden" name="id_campus_origen" value="<?php echo $tranferencia['id_campus'][$i] ?>">
<div class="form-wrapper col-sm-4">
    <label>Material/Equipo Prestado</label>
    <div class="form-group">
        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre" value="<?php echo $tranferencia['producto'][$i]; ?>" readonly>
    </div>
</div>
<div class="form-wrapper col-sm-4">
    <label>Cantidad transferida</label>
    <div class="form-group">
        <input type="text" class="form-control esnumero" name="" id="cantidad" placeholder="Cantidad" value="<?php echo $tranferencia['cantidad'][$i]; ?>" readonly>
    </div>
</div>
<div class="form-wrapper col-sm-4">
    <label>Cantidad de entrada</label>
    <div class="form-group">
        <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad" placeholder="Cantidad" value="" autocomplete="FALSE">
    </div>
</div>
<div class="form-wrapper col-sm-4">
    <label>Estado de la transferencia</label>
    <div class="form-group">
        <select name="estatus[]" id="estatus" class="form-control validar">
            <option value="0">Selecciona un estatus</option>
            <option value="3">Entrada Incompleta</option>
            <option value="4">Entrada Completa</option>
        </select>
    </div>
</div>

<?php } ?>