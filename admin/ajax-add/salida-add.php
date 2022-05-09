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
                    <div class="form-wrapper col-sm-4" id="listausarios">
                        
                    </div>
                </div>
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
                        <label>Cantidad de entrada</label>
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
                </div>
                <div id="nueva_entrada"></div>
                <div class="row">
                    <div class="col-3">
                        <input class="btn btn-success clonadorboton letrablanca" placeholder="Agregar entrada +" id="clonador_1" onclick="ClonarDIV();" readonly>
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('salida-add', 'pr-entradas-salidas', this);">
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
            $("#nombre_proyecto").css({ display: "none" });
            $.ajax({
                url: "ajax-get/lista-usuarios",
                success: function(response){
                    $('#listausarios').html(response);
                }
            });
        }else if(valor == 0 || valor == 2){
            var listausarios = document.getElementById('listausarios');
            listausarios.children[0].remove(listausarios);
            listausarios.children[0].remove(listausarios);
            $("#nombre_proyecto").css({ display: "block" });
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