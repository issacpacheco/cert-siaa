<?php
include("../class/allClass.php");
use conexionbd\mysqlconsultas;
$ejecucion = new mysqlconsultas();


if(isset($_POST['eliminar'])){
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $qry1 = "DELETE FROM inv_productos WHERE id = $id";
    $ejecucion->ejecuta($qry1);

    $qry2 = "DELETE FROM inv_campus_producto WHERE id_producto = $id AND id_campus = 1";
    $ejecucion->ejecuta($qry2);
    echo "eliminado correctamente";
}else{
    
?>
<form action="eliminar-productos.php" method="POST">
    <div class="row">
        <div class="form-grupo">
            <label for="">Escribe el id</label>
            <input type="text" value="" name="id" id="id" placeholder="escribe aqui el id">
        </div>
        <div class="form-group">
            <button type="submit" name="eliminar" value="eliminar" class="btn btn-danger">Eliminar</button>
        </div>
    </div>
</form>
<?php
}
?>