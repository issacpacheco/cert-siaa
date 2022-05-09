<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsusuarios\usuarios;
use nsfunciones\funciones;

$info       = new almacen();
$fn         = new funciones();
$infousu    = new usuarios();


$usuarios   = $infousu  -> obtener_almacenistas();
$cusuarios  = $fn       -> cuentarray($usuarios);


$materiales     = $info -> obtener_materiales_salida();
$cmateriales    = $fn   -> cuentarray($materiales);

$almacenes      = $info -> obtener_almacenes();
$calmacenes     = $fn   -> cuentarray($almacenes);

?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Agrega transferencia de salida
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>Seleccione a responsable de envio</label>
                        <div class="form-group">
                            <select name="id_responsable" id="id_responsable" class="form-control validar">
                                <option value="">Seleccione una opción</option>
                                <?php for($i = 0; $i < $cusuarios; $i++){?>
                                    <option value="<?php echo $usuarios['id'][$i]; ?>"><?php echo $usuarios['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Seleccione campus de destino</label>
                        <div class="form-group">
                            <select name="id_campus_destino" id="id_campus_destino" class="form-control validar">
                                <option value="">Seleccione una opción</option>
                                <?php for($i = 0; $i < $calmacenes; $i++){?>
                                    <option value="<?php echo $almacenes['id'][$i]; ?>"><?php echo $almacenes['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="entrada_add">
                    <div class="form-wrapper col-sm-4">
                        <label>Selecciona material/producto</label>
                        <div class="form-group">
                            <select name="producto[]" id="producto" class="form-control" onchange="obtener_cantidad();">
                                <option value="NA">Selecciona un material/producto</option>
                                <?php for($i = 0; $i < $cmateriales; $i++){ ?>
                                <option value="<?php echo $materiales['id'][$i]; ?>"><?php echo $materiales['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Cantidad de salida(queda <strong id="cantidad_dispo">10</strong> disponibles de este producto/material/etc..)</label>
                        <div class="form-group">
                            <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad" placeholder="Cantidad" value="" autocomplete="FALSE">
                        </div>
                    </div>
                </div>
                <div id="nueva_entrada"></div>
                <div class="row">
                    <div class="col-3">
                        <input type="button" class="btn btn-success clonadorboton letrablanca" placeholder="Agregar transferencia salida +" value="Agregar transferencia salida +" id="clonador_1" onclick="ClonarDIV();" readonly>
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('transferencia-salida-add', 'pr-transferencia', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function prestamoMaterial(){
        var valor = document.getElementById("prestamo").value;
        if(valor == 1){
            $.ajax({
                url: "ajax-get/lista-usuarios",
                success: function(response){
                    $('#listausarios').html(response);
                }
            });
        }else if(valor == 0 || valor == 2){
            var listausarios = document.getElementById('listausarios');
            promoDif.children[0].remove(listausarios)
            promoDif.children[0].remove(listausarios)
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