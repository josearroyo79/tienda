<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/tienda/admin/producto/dirs.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once UTILITY_PATH."funciones.php";

// Compramos la existencia del parámetro id antes de usarlo
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Cargamos el controlador de alumnos
    $id = decode($_GET["id"]);
    $controlador = ControladorProducto::getControlador();
    $producto= $controlador->buscarProducto($id);
    if (is_null($producto)){
        // hay un error
        header("location: error.php");
        exit();
    } 
}
?>

<!-- Cabecera de la página web -->
<?php require_once VIEW_PATH."cabecera.php"; ?>

<!-- Cuerpo de la página web -->
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Ficha de Producto</h1>
                    </div>
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                                <div class="form-group" class="align-left">
                                    <label>Nombre</label>
                                    <p class="form-control-static"><?php echo $producto->getNombre(); ?></p>
                                </div>
                            </td>
                            <td class="align-left">
                                <label>Fotografía</label><br>
                                <img src='<?php echo "../imagen_producto/" . $producto->getImagen() ?>' class='rounded' class='img-thumbnail' width='60' height='auto'>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <label>Tipo</label>
                        <p class="form-control-static"><?php echo $producto->getTipo(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Marca</label>
                            <p class="form-control-static"><?php echo $producto->getMarca(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                        <p class="form-control-static"><?php echo $producto->getPrecio()."€"; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Unidades</label>
                            <p class="form-control-static"><?php echo $producto->getUnidades(); ?></p>
                    </div>
                    <p><a href="../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</a></p>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH."pie.php"; ?>
