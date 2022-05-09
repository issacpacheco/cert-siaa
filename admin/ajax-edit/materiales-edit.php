<?php
include('../class/allClass.php');

$regresar   = filter_input(INPUT_POST, 'regresar',      FILTER_SANITIZE_STRING);
$postload   = filter_input(INPUT_POST, 'returnpage',    FILTER_SANITIZE_STRING);
$div        = filter_input(INPUT_POST, 'load',          FILTER_SANITIZE_STRING);
$id         = filter_input(INPUT_POST, 'id',            FILTER_SANITIZE_NUMBER_INT);

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();


$material       = $info -> obtener_material($id);
$fotos          = $info -> obtener_fotos_materiales($id);
$cfotos         = $fn   -> cuentarray($fotos);
$categorias     = $info -> obtener_categorias();
$ccategorias    = $fn   -> cuentarray($categorias);    
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
                            <input type="text" class="form-control esnumero" name="cantidad" id="cantidad" placeholder="<?php echo $material['cantidad'][0]; ?>" value="<?php echo $material['cantidad'][0]; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Descripcion</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion" value="<?php echo $material['descripcion'][0]; ?>">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Codigo de barras</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo de barras" value="<?php echo $material['numero_serie'][0]; ?>">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Categoria</label>
                        <div class="form-group">
                            <select name="categoria" id="categoria" class="form-control">
                                <option value="<?php echo $material['id_categoria'][0]; ?>" selected><?php echo $material['categoria'][0]; ?></option>
                                <?php for($i = 0; $i < $ccategorias; $i++){ ?>
                                <option value="<?php echo $categorias['id'][$i]; ?>"><?php echo $categorias['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Estatus</label>
                        <div class="form-group">
                            <select name="estatus" id="estatus" class="form-control">
                                <option value="<?php echo $material['estatus'][0]; ?>"><?php if($material['estatus'][0] == 1){ echo "Activo"; }else{ echo "Inactivo"; } ?></option>
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="cajongaleria" class="left full border-gris h180 mtop20">
                    <?php for ($i = 0; $i < $cfotos; $i++) { 
                        if($fotos["favorito"][$i]==0){
                            $clasecolor = "letrablanca";
                        }else{
                            $clasecolor = "letramarilla";
                        }
                        ?>
                        <div class="thumbnail relative" id="foto_<?php echo $fotos["id"][$i] ?>" title="<?php echo $fotos["foto"][$i]; ?>">                        
                            <img src="upload/materiales/<?php echo $fotos["foto"][$i]; ?>" class="responsive" />
                            <div class="portaelimina">
                                <i class="borrarimagen fas fa-trash-alt letraroja font18 pointer" onclick="eliminarImagen('<?php echo $fotos['id'][$i]; ?>', '<?php echo $fotos['foto'][$i]; ?>','eliminar-foto-material')" title="Eliminar imagen"></i>
                                <i class="starimg far fa-star <?php echo $clasecolor; ?> pointer" id="star_<?php echo $fotos["id"][$i]; ?>" onclick="ConvertirStarImagen('<?php echo $fotos['id'][$i]; ?>', '<?php echo $material['id'][0]; ?>','foto-favorita-materiales')" title="Hacer favorito"></i>
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
    </div>
</div>

<script>


function uploadData(formdata) {
        $.ajax({
            url: '../admin/ajax-save/upload-materiales',
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
                     <img src="upload/materiales/' + name + '" class="responsive" />\n\
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


</script>