<?php 
include('../class/allClass.php');

$folio = filter_input(INPUT_POST, 'folio', FILTER_SANITIZE_SPECIAL_CHARS);
use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$prestamos   = $info -> obtener_prestamos($folio);
$cprestamos  = $fn   -> cuentarray($prestamos);

for($i = 0; $i < $cprestamos; $i++){

?>

<input type="hidden" name="producto[]" value="<?php echo $prestamos['id_producto'][$i] ?>">
<input type="hidden" name="idsolicitante" value="<?php echo $prestamos['id_solicitante'][$i] ?>">
<div class="form-wrapper col-sm-3">
    <label>Material/Equipo Prestado</label>
    <div class="form-group">
        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre" value="<?php echo $prestamos['producto'][$i]; ?>" readonly>
    </div>
</div>
<div class="form-wrapper col-sm-3">
    <label>Cantidad Prestada (Por devolver o Pendiente a devolver)</label>
    <div class="form-group">
        <input type="text" class="form-control esnumero" name="" id="cantidad" placeholder="Cantidad" value="<?php echo $prestamos['cantidad_prestada'][$i]; ?>" readonly>
    </div>
</div>
<div class="form-wrapper col-sm-3">
    <label>Cantidad de entrada a devolver</label>
    <div class="form-group">
        <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad_dev" placeholder="Cantidad" value="" autocomplete="FALSE">
    </div>
</div>
<div class="form-wrapper col-sm-3">
    <label>Estado del prestamo</label>
    <div class="form-group">
        <select name="estatus[]" id="estatus" class="form-control validar">
            <option value="0">Selecciona un estatus</option>
            <option value="4">Devolución Incompleta</option>
            <option value="5">Devolución Completa</option>
        </select>
    </div>
</div>

<?php } ?>