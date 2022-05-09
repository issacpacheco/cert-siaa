<?php
include('../class/allClass.php');

use nsalmacen\almacen;
use nsfunciones\funciones;

$info   = new almacen();
$fn     = new funciones();


$categorias = $info->obtener_categorias();
$ccategorias = $fn->cuentarray($categorias);
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
                        <label>Estatus</label>
                        <div class="form-group">
                            <select name="estatus" id="estatus" class="form-control">
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mright textright">
                    <button type="button" class="btnRegresar right btngral" onclick="saveInfo('materiales-add', 'pr-materiales', this);">
                        <span class="letrablanca font14">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>