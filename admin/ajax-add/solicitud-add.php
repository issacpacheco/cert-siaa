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
            Realizar una solicitud de Material/Producto/Equipo/Etc...
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <div class="row" id="entrada_add">
                    <div class="form-wrapper col-sm-4">
                        <label>Selecciona material/producto</label>
                        <div class="form-group">
                            <select name="producto[]" id="" class="form-control">
                                <option value="">Selecciona un material/producto</option>
                                <?php for($i = 0; $i < $cmateriales; $i++){ ?>
                                <option value="<?php echo $materiales['id'][$i]; ?>"><?php echo $materiales['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Cantidad a solicitar</label>
                        <div class="form-group">
                            <input type="text" class="form-control esnumero" name="cantidad[]" id="cantidad" placeholder="Cantidad" value="" autocomplete="FALSE">
                        </div>
                    </div>
                </div>
                <div id="nueva_entrada"></div>
                <div class="row">
                    <div class="col-3">
                        <input type="button" class="btn btn-success clonadorboton letrablanca" value="Agregar +" placeholder="Agregar +" id="clonador_1" onclick="ClonarDIV();" readonly>
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('solicitud-add', 'pr-solicitudes', this);">
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