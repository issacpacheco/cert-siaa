<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();


$materiales     = $info -> obtener_materiales_salida();
$cmateriales    = $fn   -> cuentarray($materiales);
?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Agregar salida de Material/Producto/Equipo/Etc...
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>¿La salida es por prestamo?</label>
                        <div class="form-group">
                            <select name="prestamo" id="prestamo" onchange="prestamoMaterial();" class="form-control validar">
                                <option value="">Seleccione una opción</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-wrapper col-sm-6" id="listausarios">
                        
                    </div>
                </div>
                <div class="row" id="entrada_add">
                    <div class="form-wrapper col-sm-4">
                        <label>Selecciona material/producto</label>
                        <div class="form-group">
                            <select name="producto[]" id="producto" class="form-control js-example-basic-single" onchange="obtener_cantidad();">
                                <option value="">Selecciona un material/producto</option>
                                <?php for($i = 0; $i < $cmateriales; $i++){ ?>
                                <option value="<?php echo $materiales['id'][$i]; ?>"><?php echo $materiales['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Cantidad de salida(<strong id="cantidad_dispo">10</strong> disponibles de este material)</label>
                        <div class="form-group">
                            <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad" placeholder="Cantidad" value="" autocomplete="FALSE">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4" id="nombre_proyecto" style="display: none;">
                        <label>Proyecto donde se usara</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="proyecto[]" id="proyecto" placeholder="proyecto" value="" autocomplete="FALSE">
                        </div>
                    </div>
                    <div class="row" id="rango_fechas" style="display: none;">
                        <label for="">Selecciona un rango de fecha del prestamo</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="fechas"  name="fechas[]" readonly>
                        </div>
                    </div>
                </div>
                <div id="nueva_entrada"></div>
                <div class="row">
                    <div class="col-3">
                        <input class="btn btn-success clonadorboton letrablanca" placeholder="Agregar entrada +" id="clonador_1" onclick="ClonarDIV();" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label for="">Comentarios</label>
                        <textarea name="comentarios" id="comentarios" class="form-control left full" placeholder="Comentarios" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('salida-add', 'ajax-edit/fotos-prestamos', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Date-range-picker -->
<script src="plugins/moment/min/moment.min.js"></script>
<script src="plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var maxLimitDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate() + 15, 0, 0, 0, 0);
        $('#fechas').daterangepicker({
            "minDate": today,
            "maxDate": maxLimitDate,
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Seleccionar",
                "cancelLabel": "Cancelar",
                "fromLabel": "De",
                "toLabel": "Al",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        });
    });
    function prestamoMaterial(){
        var valor = document.getElementById("prestamo").value;
        if(valor == 1){
            $("#nombre_proyecto").css({ display: "none" });
            $("#rango_fechas").css({ display: "block" });
            $.ajax({
                type: "POST",
                url: "ajax-get/lista-usuarios",
                data: {tipo: 1},
                success: function(response){
                    $('#listausarios').html(response);
                    $(document).ready(function () {
                        $('#listavacia').click(function () {
                            if ($('#listavacia').is(':checked')) {
                                $('#formularionuevousuario').removeClass("oculto");
                            } else {
                                $('#formularionuevousuario').addClass("oculto")
                            }
                        });
                        $('#validacionadmin').click(function () {
                            if ($('#validacionadmin').is(':checked')) {
                                $('#estudiantes').addClass("oculto")
                            } else {
                                $('#estudiantes').removeClass("oculto");
                            }
                        });
                    });
                }
            });
        }else if(valor == 0 || valor == 2){
            <?php if($_SESSION['area'] == 6){ ?>
            $.ajax({
                type: "POST",
                url: "ajax-get/lista-usuarios",
                data: {tipo: 2},
                success: function(response){
                    $('#listausarios').html(response);
                }
            });
            <?php } ?>
            var listausarios = document.getElementById('listausarios');
            listausarios.children[0].remove(listausarios);
            listausarios.children[0].remove(listausarios);
            $("#rango_fechas").css({ display: "none" });
            $("#nombre_proyecto").css({ display: "block" });
        }
    }

    function obtener_cantidad(){
        var producto = document.getElementById("producto").value;
        $.ajax({
            type: "POST",
            url: "ajax-get/cantidad-disponible",
            data: {id_producto: producto},
            success: function(response){
                $("#cantidad_dispo").html(response);
            }
        })
    }

    function ClonarDIV(){
        var original = document.getElementById("entrada_add");
        var clon = original.cloneNode(original);
        // clon.id = infoPax;
        var destino = document.getElementById("nueva_entrada");
        destino.appendChild(clon);
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var maxLimitDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate() + 15, 0, 0, 0, 0);

        var documento = document.getElementById("nueva_entrada");
        var contador = documento.childElementCount;
        if(contador == 1){
            var cambio = destino.appendChild(clon);
            var num = Number(contador + 1);
            var cambiofechas = cambio.children[3].children[1].children[1];
            cambiofechas.id = "fechas_"+num;
            $('#fechas_'+num).daterangepicker({
                "minDate": today,
                "maxDate": maxLimitDate,
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Seleccionar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "toLabel": "Al",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            });
            var cambioselector = cambio.children[0].children[1].children[0];
            cambioselector.className = "js-example-basic-single_"+num;
            cambioselector.id = "producto_"+num;
            $('.js-example-basic-single_'+num).select2();
            var span = documento.children[0].children[0].children[1].children[2];
            span.parentElement.removeChild(span)
        }else{
            var cambio = destino.appendChild(clon);
            var num = Number(contador + 1);
            var cambioselector = cambio.children[0].children[1].children[0];
            cambioselector.className = "js-example-basic-single_"+num;
            cambioselector.id = "producto_"+num;
            $('.js-example-basic-single_'+num).select2();
        }
        
        var botonelim = document.createElement('button');
        botonelim.textContent = 'Eliminar entrada -';
        botonelim.classList = 'btn btn-danger mbottom20 mleft20';
        botonelim.addEventListener('click', ()=>{eliminar(event,clon)});
        document.getElementById('nueva_entrada').appendChild(botonelim);
    }

    function eliminar(event,clon){
        event.target.parentElement.removeChild(event.target);
        clon.parentElement.removeChild(clon);
    }
</script>