<?php
include("../class/allClass.php");

$regresar   = filter_input(INPUT_POST, 'regresar', FILTER_SANITIZE_STRING);
$div        = filter_input(INPUT_POST,'', FILTER_SANITIZE_STRING);

use nsfunciones\funciones;
use nstransporte\transporte;

$cat = new transporte();
$fn = new funciones();

$vehiculos      = $cat  ->  getVehiculos();
$cvehiculos     = $fn   ->  cuentarray($vehiculos);

$operadores     = $cat  ->  getOperadores();
$coperadores    = $fn   ->  cuentarray($operadores);


?>

<div class="left full cabecera fondoblanco mtop20" id="frmCabecera">
    <div class="left col6 small5">
        <h1 class="left full titulodashboard letraazul">Registro de gastos adicionales </h1>

    </div>

    <div class="right small5">
        <button type="button" class="btnRegresar left btngral" id="btnAdd" onclick="returnPage('<?php echo $regresar; ?>')">
            <span class="fas fa-chevron-circle-left iconobtnregresar"></span>
            Regresar
        </button>


    </div>
</div>

<dipagev class="left full mtop20 fondoblanco mbottom3 padding15">
    <h2 class="titulodetalles left full">Información general del mantenimiento</h2>
    <form id="frmRegistro">
        <div class="left full mtop20 paddingbottom15">
            <input type="hidden" name="imagen" id="imagen" value=""/>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">
                <label class="left full">Fecha:</label>
                <input type="date" name="fch_registro" id="fch_registro" value="" class="left full validar" autocomplete="off" />
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell"></div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell"></div>
        </div>
        <div class="left full mtop20 separador_abajo paddingbottom15">
            <input type="hidden" name="imagen" id="imagen" value=""/>
            <div class="left col4 small12 paddingright15 mbottom30 nopaddingrightcell">
                <label class="left full">Concepto:</label>
                <input type="text" name="concepto" id="concepto" value="" class="left full validar mbottom20" autocomplete="off" />

                <label class="left full">Vehiculo:</label>
                <select name="idvehiculo" id="idvehiculo" class="left full validar mbottom20 validar">
                    <option value="0">Selecciona un vehiculo</option>
                    <?php for($v = 0; $v < $cvehiculos; $v++){ ?>
                    <option value="<?php echo $vehiculos['id'][$v]; ?>"><?php echo $vehiculos['vehiculo'][$v]; ?></option>
                    <?php } ?>
                </select>

                <label class="left full">Comentarios:</label>
                <textarea name="comentario" id="comentario" class="left full h180" onfocusin="textareaIN(this, 'Escriba aqui')" onfocusout="textareaOUT(this, 'Escriba aqui')">Escriba aqui</textarea>
                
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Referencia:</label>
                <input type="text" name="referencia" id="referencia" value="" class="left full mbottom20" autocomplete="off" />

                <label class="left full">Operador:</label>
                <select name="idoperador" id="idoperador" class="left full validar mbottom20 validar">
                    <option value="0">Selecciona un vehiculo</option>
                    <?php for($v = 0; $v < $coperadores; $v++){ ?>
                    <option value="<?php echo $operadores['id'][$v]; ?>"><?php echo $operadores['nombre'][$v]; ?></option>
                    <?php } ?>
                </select>

            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Monto:</label>
                <input type="text" name="monto" id="monto" value="" class="left full mbottom20" autocomplete="off" />

            </div>
        </div>
        <div class="left full mtop30">
            <button type="button" class="btnRegresar right btngral" onclick="saveInfo('tr-gastos-adicionales-add', 'pr-tr-gastos-adicionales', this);">
                <span class="letrablanca font14">Guardar</span>
            </button>
        </div>
    </form>
</dipagev>
<script> 
    $(document).ready(function () {
        $("#servicios").select2();
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#fch_registro").datepicker({
            dateFormat: "yy-mm-dd",
            closeText: 'Cerrar',
            changeMonth: true,
            changeYear: true,
            prevText: '<Ant',
            nextText: 'Sig>',
        });
        $('#hra_registro').timepicker({
            format:'Y-m-d H:i:ss',
            interval: 60,
            minTime:'00:00',
            maxTime:'23:00'
        });

        $("#idvehiculo").on('change', function () {
            $("#idvehiculo option:selected").each(function () {
                var id_vehiculo = $(this).val();
                console.log(id_vehiculo);
                $.post("ajax-get/get-odometro-actual", { id_vehiculo: id_vehiculo }, function(data) {
                    $("#odometroActual").html(data);
                });			
            });
        });
    });
</script>