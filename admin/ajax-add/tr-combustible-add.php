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
        <h1 class="left full titulodashboard letraazul">Registro carga de combustible </h1>

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
        <div class="left full mtop20 separador_abajo paddingbottom15">
            <input type="hidden" name="imagen" id="imagen" value=""/>
            <div class="left col4 small12 paddingright15 mbottom30 nopaddingrightcell">
                <label class="left full">Fecha:</label>
                <input type="date" name="fch_registro" id="fch_registro" value="" class="left full validar mbottom20" autocomplete="off" />

                <label class="left full">Vehiculo:</label>
                <select name="idvehiculo" id="idvehiculo" class="left full validar mbottom20 validar">
                    <option value="0">Selecciona un vehiculo</option>
                    <?php for($v = 0; $v < $cvehiculos; $v++){ ?>
                    <option value="<?php echo $vehiculos['id'][$v]; ?>"><?php echo $vehiculos['vehiculo'][$v]; ?></option>
                    <?php } ?>
                </select>
                
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Hora:</label>
                <input type="text" name="hra_registro" id="hra_registro" value="" class="left full mbottom20" autocomplete="off" />

            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Referencia:</label>
                <input type="text" name="referencia" id="referencia" value="" class="left full mbottom20" autocomplete="off" />

            </div>
        </div>
        <h2 class="titulodetalles left full">Información de carga</h2>
        <div class="left full mtop20  paddingbottom15">
            <div class="left col4 small12 paddingright15  nopaddingrightcell">
                <label class="left full">Tipo de combustible:</label>
                <select name="tip_combustible" id="tip_combustible" class="left validar validar">
                    <option value="0">Seleccione tipo de combustible</option>
                    <option value="1">Regular</option>
                    <option value="2">Premium</option>
                </select>  
            </div>
        </div>
        <div class="left mtop20  paddingbottom15">
            <div class="left col4 small12 paddingright15 mbottom30 nopaddingrightcell">
                <label class="left full">Cantidad cargada:</label>
                <input type="text" name="carga" id="carga" value="" class="left full validar mbottom20 esprecio monto" autocomplete="off" />  
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Costo de gasolina:</label>
                <input type="text" name="costo_gasolina" id="costo_gasolina" value="" class="left full mbottom20 esprecio monto" autocomplete="off" />

            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Odómetro: <span id="odometroActual">(Actual : <?php echo "hola mundo"; ?>)</span></label>
                <input type="text" name="odometro" id="odometro" value="" class="left full validar mbottom20 esprecio" autocomplete="off" />

            </div>

        </div>
        <div class="left full mtop30">
            <button type="button" class="btnRegresar right btngral" onclick="saveInfo('tr-combustible-add', 'pr-tr-combustibles', this);">
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