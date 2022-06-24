<?php
include("../class/allClass.php");

$regresar = filter_input(INPUT_POST, 'regresar', FILTER_SANITIZE_STRING);
$div = filter_input(INPUT_POST,'', FILTER_SANITIZE_STRING);

use nscatalogos\catalogo;
use nsfunciones\funciones;
use nstransporte\transporte;

$cat = new transporte();
$fn = new funciones();

?>

<div class="left full cabecera fondoblanco mtop20" id="frmCabecera">
    <div class="left col6 small5">
        <h1 class="left full titulodashboard letraazul">Registro de Vehiculo </h1>

    </div>

    <div class="right small5">
        <button type="button" class="btnRegresar left btngral" id="btnAdd" onclick="returnPage('<?php echo $regresar; ?>')">
            <span class="fas fa-chevron-circle-left iconobtnregresar"></span>
            Regresar
        </button>


    </div>
</div>

<dipagev class="left full mtop20 fondoblanco mbottom3 padding15">
    <h2 class="titulodetalles left full">Información general del vehiculo</h2>
    <div class="left full mtop20 separador_abajo paddingbottom15">
        <form id="frmRegistro">
            <input type="hidden" name="imagen" id="imagen" value=""/>
            <div class="left col4 small12 paddingright15 mbottom30 nopaddingrightcell separador_abajo">
                <label class="left full">Nombre del vehiculo:</label>
                <input type="text" name="nombre" id="nombre" value="" class="left full validar mbottom20" autocomplete="off" />

                <label class="left full">Marca del vehiculo:</label>
                <input type="text" name="marca" id="marca" value="" class="left full validar mbottom20 validar" autocomplete="off" />

                <label class="left full">Modelo del vehiculo:</label>
                <input type="text" name="modelo" id="modelo" value="" class="left full validar mbottom20 validar" autocomplete="off" />

                <label class="left full">Año del vehiculo:</label>
                <input type="text" name="anio" id="anio" value="" class="left full validar mbottom20 validar esprecio" autocomplete="off" />
                
                <label class="left full">Descripción del vehiculo</label>
                <textarea name="descripcion" id="descripcion" class="left full validar h100 mbottom10" placeholder="Escribe una descripcion del vehiculo"></textarea>
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell">
                <label class="left full">Tipo de vehiculo:</label>
                <select name="tip_vehiculo" id="tip_vehiculo" class="left full mbottom20">
                    <option value="Camion">Camion</option>
                    <option value="Automovil">Automovil</option>
                    <option value="Combi">Combi</option>
                </select>

                <label class="left full">Estatus inicial:</label>
                <select name="estatus_ini" id="estatus_ini" class="left full mbottom20">
                    <option value="1">Disponible</option>
                    <option value="2">Asignado</option>
                    <option value="3">En taller</option>
                </select>

                <label class="left full">Litros de tanque:</label>
                <input type="text" name="lts_tanque" id="lts_tanque" value="" class="left full validar mbottom20 esprecio" autocomplete="off" />

                <label class="left full">Odometro Inicial:</label>
                <input type="text" name="odometro" id="odometro" value="" class="left full validar mbottom20 esprecio" autocomplete="off" />

                <label class="left full">Numero de asientos:</label>
                <input type="text" name="noasientos" id="noasientos" value="" class="left full validar mbottom20 esprecio" autocomplete="off" />
            </div>
            <div class="col4 small12 paddingright15 nopaddingrightcell">
                <h2 class="titulodetalles mbottom10 left full">Información adicional</h2>
                
                <label class="left full">Numero de serie:</label>
                <input type="text" name="noserie" id="noserie" value="" class="left full validar mbottom20 validar" autocomplete="off" />

                <label class="left full">Tarjeta de circulación:</label>
                <input type="text" name="tarjeta_circulacion" id="tarjeta_circulacion" value="" class="left full validar mbottom20 validar" autocomplete="off" />

                <label class="left full">Placas:</label>
                <input type="text" name="placas" id="placas" value="" class="left full validar mbottom20 validar" autocomplete="off" />
            </div>
            <div class="left col4 small12 paddingright15 nopaddingrightcell" style="position:relative;left:15px;top:-147px;">
                <label class="left full">Compañia de seguro:</label>
                <input type="text" name="seguro" id="seguro" value="" class="left full validar mbottom20 validar" autocomplete="off" />

                <label class="left full">Poliza de seguro:</label>
                <input type="text" name="poliza" id="poliza" value="" class="left full validar mbottom20 validar" autocomplete="off" />

                <label class="left full">Vigencia de la poliza:</label>
                <input type="date" name="fch_vig" id="fch_vig" value="" class="left full validar mbottom20 validar" autocomplete="off" />
            </div>

            <div class="left full mtop30">
                <button type="button" class="btnRegresar right btngral" onclick="saveInfo('vehiculo-add', 'pr-tr-vehiculo', this);">
                    <span class="letrablanca font14">Guardar</span>
                </button>
            </div>
        </form>
    </div>
</dipagev>
<script> 
    $(document).ready(function () {
        $("#fch_vig").datepicker({
            dateFormat: "yy-mm-dd",
            closeText: 'Cerrar',
            changeMonth: true,
            changeYear: true,
            prevText: '<Ant',
            nextText: 'Sig>'
        });
    });
</script>