<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();


$materiales     = $info -> obtener_materiales();
$cmateriales    = $fn   -> cuentarray($materiales);
?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Agregar Entrada de Material/Producto/Equipo/Etc...
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>¿La entrada es por prestamo?</label>
                        <div class="form-group">
                            <select name="prestamo" id="prestamo" onchange="prestamoMaterial();" class="form-control validar">
                                <option value="">Seleccione una opción</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4" id="folio" style="display: none;">
                        <label>Clave de prestamo</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="folio" id="clave" placeholder="Capturar clave" value="" autocomplete="FALSE">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4" id="botonbus" style="display: none;">
                        <label></label>
                        <div class="form-group">
                            <input type="button" class="btn btn-info buscarPrestamos letrablanca" value="Buscar" id="buscarPrestamos" onclick="obtenerprestamos();" readonly>
                        </div>
                    </div>
                </div>
                <div class="row" id="listadoprestamos">

                </div>
                <div class="row">
                    <div class="form-wrapper col-sm-4" id="validar_factura">
                        <label>¿La entrada es por factura?</label>
                        <div class="form-group">
                            <select name="facturaSelect" id="facturaselect" onchange="IncluyeFactura();" class="form-control validar">
                                <option value="">Seleccione una opción</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4" id="factura" style="display: none;">
                        <label>Factura</label>
                        <div class="form-group">
                            <input type="text" class="form-control validar" name="factura" id="factura_precio" placeholder="Capturar la Factura" value="" autocomplete="FALSE">
                        </div>
                    </div>
                </div>
                <div class="row" id="entrada_add">
                    <div class="form-wrapper col-sm-4">
                        <label>Selecciona material/producto</label>
                        <div class="form-group">
                            <select name="producto[]" id="" class="form-control js-example-basic-single">
                                <option value="">Selecciona un material/producto</option>
                                <?php for($i = 0; $i < $cmateriales; $i++){ ?>
                                <option value="<?php echo $materiales['id'][$i]; ?>"><?php echo $materiales['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Cantidad de entrada</label>
                        <div class="form-group">
                            <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad" placeholder="Cantidad" value="" autocomplete="FALSE">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4" id="preciofactura" style="display: none;">
                        <label>Precio del material (emitido en la factura)</label>
                        <div class="form-group">
                            <input type="text" class="form-control esnumero" name="precio[]" id="precio" placeholder="precio" value="" autocomplete="FALSE">
                        </div>
                    </div>
                </div>
                <div id="nueva_entrada"></div>
                <div class="row" id="clon">
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
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('entrada-add', 'pr-entradas-salidas', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var maxLimitDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate() + 15, 0, 0, 0, 0);
    });
    function obtenerprestamos(){
        var folio = document.getElementById("clave").value;
        console.log(folio);
        $.ajax({
            type: "POST",
            url: "ajax-get/prestamos-entrada",
            data: {folio: folio},
            success: function(response){
                $('#listadoprestamos').html(response);
            }
        });
    }

    function prestamoMaterial(){
        var valor = document.getElementById("prestamo").value;
        if(valor == 1){
            $("#folio").css({ display: "block" });
            $("#botonbus").css({ display: "block" });
            $("#listadoprestamos").css({ display: "block" });
            $("#entrada_add").css({ display: "none" });
            $("#clon").css({ display: "none" });
            $("#validar_factura").css({display: "none" });
        }else if(valor == 0 || valor == 2){
            $("#entrada_add").css({ display: "block" });
            $("#clon").css({ display: "block" });
            $("#folio").css({ display: "none" });
            $("#botonbus").css({ display: "none" });
            $("#listadoprestamos").css({ display: "none" });
            $("#validar_factura").css({display: "block" });
        }
    }

    function IncluyeFactura(){
        var valor = document.getElementById("facturaselect").value;
        if(valor == 1){
            $("#factura").css({ display: "block" });
            $("#preciofactura").css({ display: "block" });
        }else if(valor == 0 || valor == 2){
            $("#factura").css({ display: "none" });
            $("#preciofactura").css({ display: "none" });
        }
    }

    function ClonarDIV(){
        var original = document.getElementById("entrada_add");
        var clon = original.cloneNode(original);
        // clon.id = infoPax;
        var destino = document.getElementById("nueva_entrada");
        destino.appendChild(clon);
        var documento = document.getElementById("nueva_entrada");
        var contador = documento.childElementCount;
        if(contador == 1){
            var cambio = destino.appendChild(clon);
            var num = Number(contador + 1);
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