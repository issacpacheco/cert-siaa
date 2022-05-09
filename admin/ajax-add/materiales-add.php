<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$borrar = $fn->BorrarCarpeta('images/productos/temp_bak');
if (!file_exists('../images/productos/temp_bak'))
{
    umask(0000);
    mkdir('../images/productos/temp_bak',0777);
    mkdir('../images/productos/temp_bak/medium',0777);
    mkdir('../images/productos/temp_bak/thumb',0777);
}
$_SESSION['id_folder']  = 'temp_bak';
$_SESSION['medium_w']   = 100;
$_SESSION['medium_h']   = 100;
$_SESSION['thumb_w']    = 500;
$_SESSION['thumb_h']    = 300;
$categorias             = $info ->  obtener_categorias();
$ccategorias            = $fn   ->  cuentarray($categorias);
$unidades               = $info ->  unidades();
$cunidades              = $fn   ->  cuentarray($unidades);
?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Agregar Material/Producto/Equipo/Etc...
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <div class="row">
                    <div class="form-wrapper col-sm-4">
                        <label>Nombre</label>
                        <div class="form-group">
                            <input type="text" class="form-control validar" name="nombre" id="nombre" placeholder="Nombre" value="">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Descripcion</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion" value="">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Numero de serie</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Numero de serie" value="">
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Categoria</label>
                        <div class="form-group">
                            <select name="categoria" id="categoria" class="form-control validar">
                                <option value="" selected>Seleccione una categoria</option>
                                <?php for($i = 0; $i < $ccategorias; $i++){ ?>
                                <option value="<?php echo $categorias['id'][$i]; ?>"><?php echo $categorias['nombre'][$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Unidad de medida</label>
                        <div class="form-group">
                            <select name="unidad" id="unidad" class="form-control validar">
                                <option value="" selected>Seleccione una unidad de medida</option>
                                <?php for($i = 0; $i < $cunidades; $i++){ ?>
                                <option value="<?php echo $unidades['id'][$i]; ?>"><?php echo $unidades['abreviacion'][$i]; ?> - <?php echo $unidades['nombre'][$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper col-sm-4">
                        <label>Estatus</label>
                        <div class="form-group">
                            <select name="estatus" id="estatus" class="form-control">
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('materiales-add', 'pr-materiales', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div> -->
            </form>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <strong>NOTA:</strong> Para mejores resultados el nombre de los archivos de imagen <strong>no debe contener espacios en blanco ni caracteres especiales</strong>.
                        </div>
                        <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
                            <div class="fileupload-buttonbar">
                                <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
                                    <span class="btn btn-success fileinput-button">
                                    <i class="fa fa-plus"></i>
                                    <span>Agregar imágenes</span>
                                    <input type="file" name="files[]" multiple>
                                    </span>
                                    <button type="submit" class="btn btn-primary start">
                                    <i class="fa fa-upload"></i>
                                    <span>Subir</span>
                                    </button>
                                    <button type="reset" class="btn btn-warning cancel">
                                    <i class="fa fa-ban"></i>
                                    <span>Cancelar subida</span>
                                    </button>
                                    <button type="button" class="btn btn-danger delete">
                                    <i class="fa fa-trash"></i>
                                    <span>Borrar</span>
                                    </button>
                                    Seleccionar todo<input type="checkbox" class="toggle">
                                    <span class="fileupload-loading"></span>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fileupload-progress fade">
                                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                        </div>
                                        <div class="progress-extended">&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                            <table role="presentation" class="table table-striped clearfix">
                                <tbody class="files"></tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mright textright">
                <button type="button" class="btnRegresar right btngral" onclick="saveInfo('materiales-add', 'pr-materiales', this);">
                    <span class="letrablanca font14">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Subiendo...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="fa fa-upload"></i>
                        <span>Subir</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="fa fa-ban"></i>
                        <span>Cancelar</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            <td>
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}?v=<?php echo rand();?>" width="100"></a>
                    {% } %}
                </span>
            </td>
            <td>
                <p class="name">
                    {% if (file.url) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                    {% } else { %}
                        <span>{%=file.name%}</span>
                    {% } %}
                </p>
                {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
            </td>
            <td>
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="fa fa-trash"></i>
                        <span>Borrar</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-warning cancel">
                        <i class="fa fa-ban"></i>
                        <span>Cancelar</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>

<script>
    $(function () {
        'use strict';

        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
                url: 'Upload',
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });


        // Enable iframe cross-domain access via redirect option:
        $('#fileupload').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '/cors/result.html?%s'
            )
        );

        if (window.location.hostname === 'blueimp.github.io') {
            // Demo settings:
            $('#fileupload').fileupload('option', {
                url: '//jquery-file-upload.appspot.com/',
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                maxFileSize: 999000,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
            });
            // Upload server status check for browsers with CORS support:
            if ($.support.cors) {
                $.ajax({
                    url: '//jquery-file-upload.appspot.com/',
                    type: 'HEAD'
                }).fail(function () {
                    $('<div class="alert alert-danger"/>')
                        .text('Upload server currently unavailable - ' +
                                new Date())
                        .appendTo('#fileupload');
                });
            }
        } else {
            // Load existing files:
            $('#fileupload').addClass('fileupload-processing');
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: $('#fileupload').fileupload('option', 'url'),
                dataType: 'json',
                context: $('#fileupload')[0]
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
            });
        }

    });
</script>