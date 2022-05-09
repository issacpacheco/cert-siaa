<?php
include("../class/allClass.php");

$postload = filter_input(INPUT_POST, 'returnpage', FILTER_SANITIZE_SPECIAL_CHARS);
$div = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_SPECIAL_CHARS);

$regresar = filter_input(INPUT_POST, 'regresar', FILTER_SANITIZE_SPECIAL_CHARS);
$div = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_SPECIAL_CHARS);

?>



<div class="popup-header left full">
    <h1 class="left full titulopopup">Importar lista de excel</h1>
</div>
<div class="popup-body left full">
    
    <div class="left col12 small12 padding5">
        <label class="left full mtop">Descargar formato de EXCEL</label>
        <button onclick="descargarExcel()" class="btn btn-success">Descargar Excel</button>
    </div>
    
</div>
<div class="popup-body left full">
    <form name="frmPopup" id="frmPopup" enctype="multipart/form-data">
        <div class="left col12 small12 padding5">
            <label class="left full mtop">Seleccione archivo Excel</label>
            <input type="file" id="excel" name="excel" value="" class="form-control left full validar">
        </div>
    </form>
</div>

<div class="popup-footer">
    <button type="button" class="btngral btnRegresar right mright" onclick="importarExcel(this)" data-page="importacion-productos" data-load="<?php echo $postload; ?>" data-div="<?php echo $div; ?>">Importar</button>
    <button type="button" class="btngral btnCancelar right mright" onclick="cerrarpopup()">Cancelar</button>

<script>
    function descargarExcel(){
        window.location.href = "../admin/upload/generales/cop_listamateriales.xlsx";
    }
</script>