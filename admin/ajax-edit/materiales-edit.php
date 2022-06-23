<?php
include('../class/allClass.php');

$regresar   = filter_input(INPUT_POST, 'regresar',      FILTER_SANITIZE_SPECIAL_CHARS);
$postload   = filter_input(INPUT_POST, 'returnpage',    FILTER_SANITIZE_SPECIAL_CHARS);
$div        = filter_input(INPUT_POST, 'load',          FILTER_SANITIZE_SPECIAL_CHARS);
$id         = filter_input(INPUT_POST, 'id',            FILTER_SANITIZE_NUMBER_INT);

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();


$material       = $info -> obtener_material($id);
$fotos          = $info -> obtener_fotos_prestamo('../upload/materiales/'.$id);
if($fotos == "no existe"){
    $cont = 0;
}else{
    $cont = count($fotos['archivo']);
}
$categorias     = $info -> obtener_categorias();
$ccategorias    = $fn   -> cuentarray($categorias);
$bodegas        = $info -> mis_bodeguitas();
$cbodegas       = $fn   -> cuentarray($bodegas);
$medidas        = $info -> obtener_unidades_de_medida();
$cmedidas       = $fn   -> cuentarray($medidas);

//Consulta para el historial del material
$historialEntrada   = $info ->  historial_material_entrada($id);
$chistorialEntrada  = $fn   ->  cuentarray($historialEntrada);

$historialSalida    = $info ->  historial_material_salida($id);
$chistorialSalida   = $fn   ->  cuentarray($historialSalida);

$precio             = $info ->  obtener_precio($id);
?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Agregar Material/Producto/Equipo/Etc...
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <input type="hidden" name="id_material" id="id_material" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>Nombre</label>
                        <div class="form-group">
                            <input type="text" class="form-control validar" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $material['nombre'][0]; ?>">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Cantidad</label>
                        <div class="form-group">
                            <input type="text" class="form-control esnumero" name="cantidad" id="cantidad" placeholder="<?php echo $material['cantidad'][0]; ?>" value="<?php echo $material['cantidad'][0]; ?>" <?php if($_SESSION['nivel'] == 1){}else{ ?> readonly <?php } ?>>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Descripcion</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion" value="<?php echo $material['descripcion'][0]; ?>">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Numero de serie</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo de barras" value="<?php echo $material['numero_serie'][0]; ?>">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Categoria</label>
                        <div class="form-group">
                            <select name="categoria" id="categoria" class="form-control">
                                <option value="0" selected>Selecciona una categoria</option>
                                <?php for($i = 0; $i < $ccategorias; $i++){ ?>
                                <option value="<?php echo $categorias['id'][$i]; ?>" <?php if($material['id_categoria'][0] == $categorias['id'][$i]){ echo  'Selected'; } ?>><?php echo $categorias['nombre'][$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Estatus</label>
                        <div class="form-group">
                            <select name="estatus" id="estatus" class="form-control">
                                <option value="2" selected>Selecciona un estatus</option>
                                <option value="1" <?php if($material['id_estatus'][0] == 1){ echo "selected"; }?>>Disponible</option>
                                <option value="0" <?php if($material['id_estatus'][0] == 0){ echo "selected"; }?>>No disponible</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Unidad de medida</label>
                        <div class="form-group">
                            <select name="id_unidad" id="id_unidad" class="form-control">
                                <option value="0" selected>Selecciona una unidad de medida</option>
                                <?php for($i = 0; $i < $cmedidas; $i++){ ?>
                                <option value="<?php echo $medidas['id'][$i]; ?>" <?php if($material['id_unidad'][0] == $medidas['id'][$i]){ echo  'Selected'; } ?>><?php echo $medidas['nombre'][$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Bodega asiganda</label>
                        <div class="form-group">
                            <select name="id_bodega" id="id_bodega" class="form-control">
                                <option value="0" selected>Selecciona una bodega</option>
                                <?php for($i = 0; $i < $cbodegas; $i++){ ?>
                                <option value="<?php echo $bodegas['id'][$i]; ?>" <?php if($material['id_bodega'][0] == $bodegas['id'][$i]){ echo  'Selected'; } ?>><?php echo $bodegas['nombre'][$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Precio de este material</label>
                        <div class="form-group">
                            <input type="text" name="precio" id="precio" class="form-control esprecio" value="<?php echo $precio['precio'][0]; ?>">
                        </div>
                    </div>
                </div>
                <div id="cajongaleria" class="left full border-gris h180 mtop20">
                    <?php for ($i = 0; $i < $cont; $i++) { ?>
                        <div class="thumbnail relative" id="foto_<?php echo $i ?>" title="<?php echo $fotos["foto"][$i]; ?>">                        
                            <img src="<?php echo $fotos["archivo"][$i]; ?>"  class="responsive" />
                            <div class="portaelimina">
                                <i class="borrarimagen fas fa-trash-alt letraroja font18 pointer" onclick="borrarArchivoPDF('<?php echo $fotos['archivo'][$i]; ?>','eliminar-foto-material',0,'<?php echo $i; ?>')" title="Eliminar imagen"></i>
                            </div>
                        </div>
                    <?php } ?>               
                </div>

                <div class="left full mtop20">
                    <input type="file" name="file" id="file" accept="image/x-png,image/gif,image/jpeg">
                    <div class="upload-area fullimportant nomtop" id="uploadfile">
                        <h1>Arrastra y suelta el archivo aqui<br />O<br />Selecciona el archivo</h1>
                    </div>                
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('materiales-edit', 'pr-materiales', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <label for="">Historial de entrada</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover fullimportant" id="tabla1">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Devolución X Prestamo</th>
                                    <th>Precio</th>
                                    <th>Ultimo usuario en modificar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i = 0; $i < $chistorialEntrada; $i++){ ?>
                                <tr>
                                    <td><?php echo $historialEntrada['cantidad'][$i]; ?></td>
                                    <td><?php echo $historialEntrada['fecha'][$i]; ?></td>
                                    <td><?php echo $historialEntrada['hora'][$i]; ?></td>
                                    <td><?php echo $historialEntrada['devolucion'][$i]; ?></td>
                                    <td><?php echo $historialEntrada['total'][$i]; ?></td>
                                    <td><?php echo $historialEntrada['usuario'][$i]; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="col-sm-6">
                    <label for="">Historial de salida</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover fullimportant" id="tabla2">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Prestamo</th>
                                    <th>Ultimo usuario en modificar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i = 0; $i < $chistorialSalida; $i++){ ?>
                                <tr>
                                    <td><?php echo $historialSalida['cantidad'][$i]; ?></td>
                                    <td><?php echo $historialSalida['fecha'][$i]; ?></td>
                                    <td><?php echo $historialSalida['hora'][$i]; ?></td>
                                    <td><?php echo $historialSalida['prestamo'][$i]; ?></td>
                                    <td><?php echo $historialSalida['usuario'][$i]; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>


function uploadData(formdata) {
        $.ajax({
            url: 'ajax-save/upload-materiales',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                addThumbnail(response);
            }
        });
    }

// Added thumbnail
    function addThumbnail(data) {
        var len = $("#cajongaleria div.thumbnail").length;

        var num = Number(len);
        num = num + 1;
        console.log(data);
        var name = data.name;
        var size = convertSize(data.size);
        var src = data.src;
        var id = data.idfoto;
        var page = "eliminar-foto-material";

        // Creating an thumbnail 
        var thumb = '<div class="thumbnail relative" id="foto_' + id + '">\n\
                     <img src="upload/materiales/<?php echo $id; ?>/' + name + '" class="responsive" />\n\
                      <div class="portaelimina">\n\
                        <span onclick="eliminarImagen(\'' + id + '\', \'' + name + '\')" class="borrarimagen fas fa-trash-alt letraroja font18 pointer tooltip" title="Eliminar imagen"></span>\n\
                        <i class="borrarimagen fas fa-trash-alt letraroja font18 pointer" onclick="eliminarImagen(\'' + id + '\', \'' + name + '\',\'' + page + '\')" title="Eliminar imagen"></i>\n\
                      </div>\n\
                    </div>';

        $("#cajongaleria").append(thumb);

        $("#uploadfile").html("<h1>Arrastra y suelta el archivo aqui<br />O<br />Selecciona el archivo</h1>");
    }

// Bytes conversion
    function convertSize(size) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (size == 0)
            return '0 Byte';
        var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
        return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

// preventing page from redirecting
    $("html").on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

// Drag enter
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#uploadfile h1").text("Suelta la imagen aqui");
    });

// Drag over
    $('.upload-area, html').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#uploadfile h1").text("Suelta la imagen aqui");
    });

    $('html').on("dragleave", function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#uploadfile").html("<h1>Arrastra y suelta el archivo aqui<br />O<br />Selecciona el archivo</h1>");
    });

// Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $("#uploadfile h1").text("Subiendo imagen....");

        var file = e.originalEvent.dataTransfer.files;
        var id_material = $("#id_material").val();
        var fd = new FormData();

        fd.append('file', file[0]);
        fd.append('id', id_material);

        uploadData(fd);
    });

// Open file selector on div click
    $("#uploadfile").click(function () {
        $("#file").click();
    });

// file selected
    $("#file").change(function () {
        $("#uploadfile h1").text("Subiendo imagen....");
        var fd = new FormData();

        var files = $('#file')[0].files[0];
        var id_material = $("#id_material").val();

        fd.append('file', files);
        fd.append('id', id_material);
        uploadData(fd);
    });

    $(document).ready(function () {
        var t = $('#tabla1').DataTable({
            "scrollX": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontró ningún registro",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros",
                "search": "Buscar",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
        var t = $('#tabla2').DataTable({
            "scrollX": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontró ningún registro",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros",
                "search": "Buscar",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
    }); 

</script>