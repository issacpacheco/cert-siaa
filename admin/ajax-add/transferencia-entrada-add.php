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
            Transferencia de Entrada de Material/Producto/Equipo/Etc...
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <div class="row">
                    <div class="form-wrapper col-sm-4" id="folio">
                        <label>Clave de transferencia</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="folio" id="clave" placeholder="Capturar clave" value="" autocomplete="FALSE">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4" id="botonbus">
                        <label></label>
                        <div class="form-group">
                            <input type="button" class="btn btn-info buscarPrestamos letrablanca" value="Buscar" id="buscarPrestamos" onclick="obtenerprestamos();" readonly>
                        </div>
                    </div>
                </div>
                <div id="listadoprestamos">

                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('transferencia-entrada-add', 'pr-transferencia', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function obtenerprestamos(){
        var folio = document.getElementById("clave").value;
        console.log(folio);
        $.ajax({
            type: "POST",
            url: "ajax-get/transferencia-entrada",
            data: {folio: folio},
            success: function(response){
                $('#listadoprestamos').html(response);
            }
        });
    }
</script>