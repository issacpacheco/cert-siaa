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

$servicios      = $cat  ->  getServiciosTaller();
$cservicios     = $fn   ->  cuentarray($servicios);

?>

<div class="left full cabecera fondoblanco mtop20" id="frmCabecera">
    <div class="left col6 small5">
        <h1 class="left full titulodashboard letraazul">Registro de mantenimiento </h1>

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
                <label class="left full">Fecha de ingreso:</label>
                <input type="date" name="fch_ini" id="fch_ini" value="" class="left full validar mbottom20" autocomplete="off" />

                <label class="left full">Fecha de salida:</label>
                <input type="date" name="fch_fin" id="fch_fin" value="" class="left full mbottom20" autocomplete="off" />

                <label class="left full">Vehiculo:</label>
                <select name="idvehiculo" id="idvehiculo" class="left full validar mbottom20 validar">
                    <option value="0">Selecciona un vehiculo</option>
                    <?php for($v = 0; $v < $cvehiculos; $v++){ ?>
                    <option value="<?php echo $vehiculos['id'][$v]; ?>"><?php echo $vehiculos['vehiculo'][$v]; ?></option>
                    <?php } ?>
                </select>

                <label class="left full">Servicio(s):</label>
                <select name="servicios[]" id="servicios" class="left full validar mbottom20" multiple="multiple">
                    <?php for($s = 0; $s < $cservicios; $s++){ ?>
                    <option value="<?php echo $servicios['id'][$s]; ?>"><?php echo $servicios['servicio'][$s]; ?></option>
                    <?php } ?>
                </select>
                
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Hora de ingreso:</label>
                <input type="text" name="hra_ini" id="hra_ingreso" value="" class="left full validar mbottom20" autocomplete="off" />

                <label class="left full">Hora de salida:</label>
                <input type="text" name="hra_fin" id="hra_salida" value="" class="left full mbottom20" autocomplete="off" />

                <label class="left full">Odometro:</label>
                <input type="text" name="odometro" id="odometro" value="" class="left full validar mbottom20 esprecio" autocomplete="off" />

            </div>
        </div>
        <h2 class="titulodetalles left full">Información adicional</h2>
        <div class="left full mtop20  paddingbottom15">
            <div class="left col4 small12 paddingright15 mbottom30 nopaddingrightcell">
                <label class="left full">Costo por trabajo:</label>
                <input type="text" name="costo_trabajo" id="costo_trabajo" onkeyup="calculoprecio(this.value)" value="" class="left full validar mbottom20 esprecio monto" autocomplete="off" />  
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Mano de obra:</label>
                <input type="text" name="mano_obra" id="mano_obra" value="" onkeyup="calculoprecio(this.value)" class="left full mbottom20 esprecio monto" autocomplete="off" />

            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Costo Total:</label>
                <input type="text" name="consto_total" id="consto_total" value="" class="left full validar mbottom20 esprecio" autocomplete="off" />

            </div>

            <div id="listincidentes">
                
            </div>

        </div>
        <div class="left full mtop20 separador_abajo paddingbottom15">
            <div class="left col4 small12 paddingright15 mbottom30 nopaddingrightcell">
                <label class="left full">Referencia:</label>
                <input type="text" name="referencia" id="referencia" value="" class="left full mbottom20" autocomplete="off" />

                <label class="left full">Tipo de mantenimiento:</label>
                <select name="mantenimiento" id="mantenimiento" class="left full validar mbottom20">
                    <option value="0">Selecciona un tipo de mantenimiento</option>
                    <option value="1">Preventivo</option>
                    <option value="2">Correctivo</option>
                </select>
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">

                <label class="left full">Comentarios:</label>
                <textarea name="comentario" id="comentario" class="left full h180" onfocusin="textareaIN(this, 'Escriba aqui')" onfocusout="textareaOUT(this, 'Escriba aqui')">Escriba aqui</textarea>

            </div>
        </div>
        <div class="left full mtop30">
            <button type="button" class="btnRegresar right btngral" onclick="saveInfo('tr-mantenimiento-add', 'pr-tr-mantenimiento', this);">
                <span class="letrablanca font14">Guardar</span>
            </button>
        </div>
    </form>
</dipagev>
<script> 
    $(document).ready(function () {
        $("#servicios").select2();
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#fch_ini").datepicker({
            dateFormat: "yy-mm-dd",
            closeText: 'Cerrar',
            changeMonth: true,
            changeYear: true,
            prevText: '<Ant',
            nextText: 'Sig>',
            onSelect: function (selectedDate) {
                $('#fch_fin').datepicker('option', 'minDate', selectedDate);
            }
        });

        $("#fch_fin").datepicker({
            dateFormat: "yy-mm-dd",
            closeText: 'Cerrar',
            changeMonth: true,
            changeYear: true,
            prevText: '<Ant',
            nextText: 'Sig>'
        });
        $('#hra_ingreso').timepicker({
            format:'Y-m-d H:i:ss',
            interval: 60,
            minTime:'00:00',
            maxTime:'23:00'
        });
        $('#hra_salida').timepicker({
            format:'Y-m-d H:i:ss',
            interval: 30,
            minTime:'00:00',
            maxTime:'23:00'
        });

        $("#idvehiculo").on('change', function () {
                $("#idvehiculo option:selected").each(function () {
                    var id_vehiculo = $(this).val();
                    console.log(id_vehiculo);
                    $.post("ajax-get/get-lista-incidentes", { id_vehiculo: id_vehiculo }, function(data) {
                        $("#listincidentes").html(data);
                        $(document).ready(function () {
                            var t = $('#example2').DataTable({
                                "scrollX": true,
                                "language": {
                                    "zeroRecords": "No se encontró ningún registro",
                                    "info": "Mostrando página _PAGE_ de _PAGES_",
                                    "infoEmpty": "No hay registros",
                                    "infoFiltered": "(filtered from _MAX_ total records)",
                                    "paginate": {
                                        "previous": "Anterior",
                                        "next": "Siguiente"
                                    }
                                }
                            });


                            t.on('xhr', function () {
                                console.log("hola");
                            });
                        
                        }); 
                    });			
                });
            })
    });
    function calculoprecio(valor) {
        var total = 0;

        $(".monto").each(function() {

            if (isNaN(parseFloat($(this).val()))) {

            total += 0;

            } else {

            total += parseFloat($(this).val());

            }

        });

        //alert(total);
        document.getElementById('consto_total').value = total;
    }
</script>