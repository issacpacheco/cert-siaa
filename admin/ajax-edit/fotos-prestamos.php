<?php 
include('../class/allClass.php');

$idsalida = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($idsalida)){
    $_SESSION['claveprestamo'] = $idsalida;
    $id = $_SESSION['claveprestamo'];
}else if(isset($_SESSION['claveprestamo'])){
    $id = $_SESSION['claveprestamo'];
}else{
    header('location: ../index.php');
}


use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$fotos = $info  -> obtener_fotos_prestamo('../upload/prestamos/'.$id);
if($fotos == "no existe"){
    $cont = 0;
}else{
    $cont = count($fotos['archivo']);
}

?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            Agrega fotos al prestamo (Esta opcion solo sera unica)
        </div>
        <div class="panel-headeing">
            <p class="letraroja">*NOTA: Toma las fotos previamente para poder subirlo a este modulo</p>
        </div>
        <div class="panel-body">
            <form id="frmRegistro">
                <input type="hidden" name="claveprestamo" id="claveprestamo" value="<?php echo $id; ?>">
                <div class="row" id="entrada_add">
                    <div id="cajongaleria" class="left full border-gris h180 mtop20">
                        <?php for ($i = 0; $i < $cont; $i++) { ?>
                            <div class="thumbnail relative" id="foto_<?php echo $i;  ?>" title="<?php echo $fotos["archivo"][$i];  ?>">                        
                                <img src="<?php echo $fotos["archivo"][$i]; ?>" class="responsive" />
                                <div class="portaelimina">
                                    <i class="borrarimagen fas fa-trash-alt letraroja font18 pointer" onclick="borrarArchivoPDF('<?php echo $fotos['archivo'][$i]; ?>','eliminar-foto-prestamo',0,'<?php echo $i; ?>')" title="Eliminar imagen"></i>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="left full mtop20">
                        <input type="file" name="file" id="file" accept="image/x-png,image/gif,image/jpeg" capture="camera">
                        <div class="upload-area fullimportant nomtop" id="uploadfile">
                            <h1>Arrastra y suelta el archivo aqui<br />O<br />Selecciona el archivo</h1>
                        </div>
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btn btn-warning" onclick="saveInfo('upload-materiales-prestamo', 'pr-entradas-salidas', this);">
                        <span class="letrablanca font14">Terminar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>


function uploadData(formdata) {
        $.ajax({
            url: 'ajax-save/upload-materiales-prestamo',
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
                     <img src="upload/prestamos/<?php echo $id ?>/' + name + '" class="responsive" />\n\
                      <div class="portaelimina">\n\
                        <span onclick="eliminarImagen(\'' + id + '\', \'' + name + '\')" class="borrarimagen fas fa-trash-alt letraroja font18 pointer tooltip" title="Eliminar imagen"></span>\n\
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
        var claveprestamo = $("#claveprestamo").val();
        var fd = new FormData();

        fd.append('file', file[0]);
        fd.append('id', claveprestamo);

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
        var claveprestamo = $("#claveprestamo").val();

        fd.append('file', files);
        fd.append('id', claveprestamo);
        uploadData(fd);
    });


</script>