<?php
include("../class/allClass.php");

$postload = filter_input(INPUT_POST, 'returnpage', FILTER_SANITIZE_SPECIAL_CHARS);
$div = filter_input(INPUT_POST, 'div', FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$lista = $info->obtener_lista_materiales($id);
$clista = $fn->cuentarray($lista);
?>



<div class="popup-header left full">
    <h1 class="left full titulopopup">Lista de materiales solicitados</h1>
</div>
<div class="popup-body left full">
    <table class="display fullimportant" id="tablaLista">
        <thead>
            <tr>
                <th> Material/Equiopo </th>
                <th> Cantidad </th>
            </tr>
        </thead>
        <tbody>
        <?php for($i = 0; $i < $clista; $i++){ ?>
            <tr>
                <td><?php echo $lista['nombre'][$i]; ?></td>
                <td><?php echo $lista['cantidad'][$i]; ?></td>
            </tr>
        <?php } ?>
        </tbody>    
    </table>
</div>

<div class="popup-footer">
    <button type="button" class="btngral btnCancelar right mright" onclick="cerrarpopup()">Cerrar</button>

<script>    
    $(document).ready(function () {
        var t = $('#tablaLista').DataTable({
            "scrollX": true,
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