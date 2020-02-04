<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/tienda/admin/producto/dirs.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

// Obtenemos los datos del alumno que nos vienen de la página anterior
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Cargamos el controlador de alumnos
    $id = decode($_GET["id"]);
    $controlador = ControladorProducto::getControlador();
    $producto = $controlador->buscarProducto($id);
    if (is_null($producto)) {
        // hay un error
        header("location: error.php");
        exit();
    }
}

// Los datos del formulario al procesar el sí.
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $controlador = ControladorProducto::getControlador();
    $producto = $controlador->buscarProducto($_POST["id"]);
    if ($controlador->borrarProducto($_POST["id"])) {
        //Se ha borrado y volvemos a la página principal
       // Debemos borrar la foto del alumno
       $controlador = ControladorImagen::getControlador();
       if($controlador->eliminarImagen($producto->getImagen())){
            header("location: ../index.php");
            exit();
       }else{
            header("location: error.php");
            exit();
        }
    } else {
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
                    <h1>Borrar Producto</h1>
                </div>
                <!-- Muestro los datos del alumno-->
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                            <div class="form-group" class="align-left">
                                <!-- Muestro los datos del alumno-->
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <p class="form-control-static"><?php echo $producto->getNombre(); ?></p>
                                </div>
                        </td>
                        <td class="align-left">
                            <label>Fotografía</label><br>
                            <img src='<?php echo "../imagen_producto/" . $producto->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
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
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este articulo?</p><br>
                        <p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a href="../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>
<br><br><br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH."pie.php"; ?>
