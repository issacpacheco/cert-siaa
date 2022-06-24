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

?>

<div class="left full cabecera fondoblanco mtop20" id="frmCabecera">
    <div class="left col6 small5">
        <h1 class="left full titulodashboard letraazul">Registro de incidencias </h1>

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
        <div class="left  mtop20 paddingbottom15">
            <input type="hidden" name="imagen" id="imagen" value=""/>
            <label class="left full">Vehiculo:</label>
            <select name="idvehiculo" id="idvehiculo" class="left full validar validar">
                <option value="0">Selecciona un vehiculo</option>
                <?php for($v = 0; $v < $cvehiculos; $v++){ ?>
                <option value="<?php echo $vehiculos['id'][$v]; ?>"><?php echo $vehiculos['vehiculo'][$v]; ?></option>
                <?php } ?>
            </select>
            
            <div class="left col4 small12 paddingright15 nopaddingrightcell"></div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell"></div>
        </div>
        <div class="left full mtop20 separador_abajo paddingbottom15">
            <div class="left col4 small12 paddingright15 mbottom30 nopaddingrightcell">

                <label class="left full">Fecha:</label>
                <input type="date" name="fch_registro" id="fch_registro" value="" class="left full validar mbottom20" autocomplete="off" />
                

                <label class="left full">Descripción detallada:</label>
                <textarea name="descrip_detallada" id="descrip_detallada" class="left full h180" onfocusin="textareaIN(this, 'Escriba aqui')" onfocusout="textareaOUT(this, 'Escriba aqui')">Escriba aqui</textarea>
                
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Descripcion Corta:</label>
                <input type="text" name="descrip_corta" id="descrip_corta" value="" class="left full mbottom20" autocomplete="off" />

            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Importancia:</label>
                <select name="importancia" id="importancia" class="left full validar mbottom20 validar">
                    <option value="0">Seleccione un nivel de importancia</option>
                    <option value="1">Critica</option>
                    <option value="2">Moderada</option>
                    <option value="3">Baja</option>
                </select>

            </div>
        </div>
        <div class="left full mtop30">
            <button type="button" class="btnRegresar right btngral" onclick="saveInfo('tr-incidentes-add', 'pr-tr-incidentes', this);">
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