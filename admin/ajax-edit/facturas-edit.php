<?php 
include('../class/allClass.php');

$regresar   = filter_input(INPUT_POST, 'regresar',      FILTER_SANITIZE_SPECIAL_CHARS);
$postload   = filter_input(INPUT_POST, 'returnpage',    FILTER_SANITIZE_SPECIAL_CHARS);
$div        = filter_input(INPUT_POST, 'load',          FILTER_SANITIZE_SPECIAL_CHARS);
$id         = filter_input(INPUT_POST, 'id',            FILTER_SANITIZE_SPECIAL_CHARS);

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();

$productos = $info -> obtener_productos_por_factura($id);
$cproductos = $fn ->  cuentarray($productos);

?>
<style>
          
        .wrapper {
            width: 90%;
            margin: 5px auto;
        }
          
        /* .trow:first-child {
            display: none;
            margin: 0 auto;
        } */
          
        .trow input {
            border-radius: 5px;
        }
          
        .controls a {
            text-decoration: none;
            color: #FFF;
        }
          
        .list_add {
            text-decoration: none;
            color: #f95858;
        }
          
        .list_add:before {
            content: "\002b";
            color: white;
            border: 1px solid #f95858;
            padding: 0 5px;
            border-radius: 5px;
            background-color: #f95858;
            margin-right: 20px;
        }
          
        .action_btn {
            text-align: center;
        }
          
        .action_btn input {
            width: 120px;
            padding: 5px;
            border-radius: 10px;
            margin: 10px;
        }
          
        .action_btn input:first-child {
            background-color: #f95858;
            color: white;
        }
          
        .fa-times {
            font-size: 1.5rem;
        }

        .margentabla {
            margin-bottom: 4rem;
        }
        .swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal{
            margin: auto;
            width: 50%;
        }
    </style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                Relación de la Factura con Folio: <h3><?php echo $id; ?></h3>
            </div>
            <div class="panel-body">
                <div class="left full fondoblanco relative paddingtop15" id="content">
                    <table class="display fullimportant margentabla" id="tabla">
                    <thead>
                        <tr>
                            <th>ID Producto</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Costo</th>
                            <th>Elliminar</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php for($i = 0; $i < $cproductos; $i++){ ?>
                                <input type="hidden" id="idproducto_<?php echo $i; ?>" value="<?php echo $productos['id_producto'][$i] ?>">
                                <input type="hidden" id="id_<?php echo $i; ?>" value="<?php echo $productos['id'][$i] ?>">
                                <input type="hidden" id="folio_<?php echo $i; ?>" value="<?php echo $id ?>">
                            <tr class="trow" id="tr_<?php echo $i; ?>">
                                <td>
                                    <input type="text" id="rollno" name="" value="<?php echo $productos['id_producto'][$i] ?>" />
                                </td>
                                <td>
                                    <input type="text" id="rollno" name="" value="<?php echo $productos['nombre_producto'][$i] ?>" />
                                </td>
                                <td>
                                    <input type="text" id="class" name="" value="<?php echo $productos['cantidad'][$i] ?>" />
                                </td>
                                <td>
                                    <input type="text" id="class" name="" value="<?php echo $productos['total'][$i] ?>" />
                                </td>
                                <td class="controls">
                                    <a onclick="eliminar_producto(<?php echo $i ?>)" class="list_cancel btn btn-danger" id="list_cancel_<?php echo $i ?>" title="Delete Row">
                                        <i class="fas fa-times"></i><span class="white"> Elimar un producto</span>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
            
                            <!-- <tr class="no_entries_row">
                                <td colspan="7">No Student Record</td>
                            </tr> -->
                        </tbody>    
                    </table>
                    <a href="#" class="list_add btn btn-danger"><span class="white">Agrega un producto</span></a>
                    <br class="clear" />
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function eliminar_producto(num){
        let idproducto  = document.getElementById("idproducto_"+num).value;
        let id          = document.getElementById("id_"+num).value;
        let folio       = document.getElementById("folio_"+num).value;
        console.log(idproducto+" "+id+" "+folio);
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: '¿Estas seguro de eliminarlo?',
            html: "Esta acción no es reversible",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si, Estoy seguro',
            cancelButtonText: 'No, Cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "ajax-delete/eliminar-producto-factura",
                    data: {idproducto: idproducto, folio: folio, id: id},
                    success: function(response){
                        console.log(response);
                        if(response == 1){
                            swalWithBootstrapButtons.fire(
                                'Eliminado!',
                                'El producto fue eliminado.',
                                'success'
                            )
                            $("#tr_"+num).css({ display: "none" });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: 'Algo salio mal, Intenta de nuevo!',
                                footer: 'Si el problema persiste comunicate con soporte'
                            });
                        }
                    }
                });
                // swalWithBootstrapButtons.fire(
                //     'Eliminado!',
                //     'El producto fue eliminado.',
                //     'success'
                // )
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Uff, por poco ;)',
                    'error'
                )
            }
        })
        console.log($(".list_cancel").length);
    }
    function addNewRow() {
        var template = $("tr.trow:first");
        $(".no_entries_row").css("display", "none");
        var newRow = template.clone();
        var lastRow = $("tr.trow:last").after(newRow);
        var tablas = document.querySelector("tbody");
        var ultimo = tablas.lastElementChild;
        ultimo.children[4].remove();
        var nuevo = tablas.lastElementChild.insertCell(4);
        nuevo.innerHTML = "<button onclick='guardarenfactura();' class='btn btn-success'>Guardar</button>";
        $("a.list_add").css({ display: "none" });

        $("select.label").on("change", function(event) {
            event.stopPropagation();
            event.stopImmediatePropagation();
            $(this).css("background-color", $(this).val());
        });
    }

    $("a.list_add").on("click", addNewRow);

    function guardarenfactura(){
        var folio       = document.getElementById("folio_0").value;
        var tablas      = document.querySelector("tbody");
        var ultimo      = tablas.lastElementChild;
        var id          = ultimo.children[0].children[0].value;
        var producto    = ultimo.children[1].children[0].value;
        var cantidad    = ultimo.children[2].children[0].value;
        var costo       = ultimo.children[3].children[0].value;
        $.ajax({
            type: "POST",
            url: "ajax-save/agregar-producto-en-factura",
            data: {folio: folio, idproducto: id, producto: producto, cantidad: cantidad, costo: costo},
            success: function(response){
                if(response == 1){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'La entrada a esta factura fue cargada con exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    var boton       = ultimo.children[4].remove();
                    $("a.list_add").css({ display: "block" });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'Algo salio mal, Intenta de nuevo!',
                        footer: 'Si el problema persiste comunicate con soporte'
                    });
                }
            }
        });
    }
</script>
