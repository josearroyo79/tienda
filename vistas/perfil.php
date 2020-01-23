<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";

// Variables temporales
$nombre = $apellidos = $correo = $password = $telefono = $imagen = "";
$nombreErr = $apellidosErr = $correoErr = $passwordErr = $telefonoErr = $imagenErr = "";
$imagenAnterior = "";

$errores = [];

// Procesamos la información obtenida por el get
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Voy a hacer un array list de errores para no procesar la imagen

    /// Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if (empty($nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif (!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } else {
        $nombre = $nombreVal;
    }

    $apellidos = filtrado($_POST["apellidos"]);

    $controlador = ControladorUsuario::getControlador();

    if (($controlador->buscarCorreo($correo)!=0) && ($controlador->buscarCorreo($correo)!=$id)) {
        $correoErr = "Ya existe un usuario en la BD con dicho correo electrónico";
        $errores[] = $correoErr;
    }

    $password = hash("sha256",(filtrado($_POST['password'])));
    if (empty($password)) {
        $passwordErr = "Contraseña incorrecta.";
        $errores[] = $passwordErr;
    }

    $telefono = filtrado($_POST["telefono"]);

    // Procesamos la imagen
    // Si nos ha llegado algo mayor que cer
    if ($_FILES['imagen']['size'] > 0 && count($errores) == 0) {
        $propiedades = explode("/", $_FILES['imagen']['type']);
        $extension = $propiedades[1];
        $tam_max = 500000; // 500 KBytes
        $tam = $_FILES['imagen']['size'];
        $mod = true;
        // Si no coicide la extensión
        if ($extension != "jpg" && $extension != "jpeg" && $extension != "png") {
            $mod = false;
            $imagenErr = "Formato debe ser jpg/jpeg";
        }
        // si no tiene el tamaño
        if ($tam > $tam_max) {
            $mod = false;
            $imagenErr = "Tamaño superior al limite de: " . ($tam_max / 1000) . " KBytes";
        }

        // Si todo es correcto, mod = true
        if ($mod) {
            // salvamos la imagen
            $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'] . time()) . "." . $extension;
            $controlador = ControladorImagen::getControlador();
            if (!$controlador->salvarImagen($imagen)) {
                $imagenErr = "Error al procesar la imagen y subirla al servidor";
            }

            // Borramos la antigua
            $imagenAnterior = trim($_POST["imagenAnterior"]);
            if ($imagenAnterior != $imagen) {
                if (!$controlador->eliminarImagen($imagenAnterior)) {
                    $imagenErr = "Error al borrar la antigua imagen en el servidor";
                }
            }
        } else {
            // Si no la hemos modificado
            $imagen = trim($_POST["imagenAnterior"]);
        }
    } else {
        $imagen = trim($_POST["imagenAnterior"]);
    }


    // Chequeamos los errores antes de insertar en la base de datos
    if (
        empty($nombreErr) && empty($apellidosErr) && empty($correoErr) && empty($correoErr) &&
        empty($telefonoErr) && empty($imagenErr)
    ) {
        // creamos el controlador de alumnado
        $controlador = ControladorUsuario::getControlador();
        $estado = $controlador->actualizarUsuario($id, $nombre, $apellidos, $correo, $correo, $telefono, $imagen);
        if ($estado) {
            $errores = [];
            // El registro se ha almacenado corectamente
            header("location: ../index.php");
            exit();
        } else {
            header("location: error.php");
            exit();
        }
    } else {
        alerta("Hay errores al procesar el formulario revise los errores");
    }
}

// Comprobamos que existe el id antes de ir más lejos
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id =  decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuario($id);
    if (!is_null($usuario)) {
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $correo = $usuario->getCorreo();
        $password = $usuario->getPassword();
        $telefono = $usuario->getTelefono();
        $imagen = $usuario->getImagen();
        $imagenAnterior = $imagen;
    } else {
        // hay un error
        header("location: error.php");
        exit();
    }
} else {
    // hay un error
    header("location: error.php");
    exit();
}

?>

<!-- Cabecera de la página web -->
<?php require_once VIEW_PATH . "cabecera.php"; ?>
<!-- Cuerpo de la página web -->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Modificar usuario</h2>
                </div>
                <p>Por favor edite la nueva información para actualizar la ficha.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <table class="table table-hover">
                        <tr>
                            <td>
                                <b><label>NOMBRE</label></b>
                                <div class="md-form <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                                    <input placeholder="Nombre" required name="nombre" type="text" id="inputPlaceholderEx" class="form-control" value="<?php echo $nombre; ?>" pattern="([^\s][A-zÀ-ž\s]+)" title="El nombre no puede contener números" minlength="3">
                                    <span class="help-block"><?php echo $nombreErr; ?></span>
                                </div>
                            </td>
                            <!-- IMAGEN -->
                            <td>
                                <b><label>IMAGEN</label></b><br>
                                <img src='<?php echo "../imagenes/" . $usuario->getImagen() ?>' class='rounded' class='img-thumbnail' width='150' height='auto'>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-hover">
                        <tr>
                            <td>
                                <!-- APELLIDOS -->
                                <div class="form-group <?php echo (!empty($apellidosErr)) ? 'error: ' : ''; ?>">
                                    <b><label>APELLIDOS</label></b>
                                    <input type="text" required name="apellidos" class="form-control" value="<?php echo $apellidos; ?>" minlength="1">
                                    <span class="help-block"><?php echo $apellidosErr; ?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- CORREO -->
                                <div class="form-group <?php echo (!empty($correoErr)) ? 'error: ' : ''; ?>">
                                    <b><label>CORREO</label></b>
                                    <input type="email" required name="correo" class="form-control" value="<?php echo $correo; ?>" minlength="1">
                                    <span class="help-block"><?php echo $correoErr; ?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- TELEFONO -->
                                <div class="form-group <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                                    <b><label>TELEFONO</label></b>
                                    <input pattern="([0-9]{9})" type="tel" required name="telefono" class="form-control" value="<?php echo $telefono; ?>" minlength="9" maxlength="9" title="El teléfono tiene que tener 9 números. Sin letras.">
                                    <span class="help-block"><?php echo $telefonoErr; ?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- IMAGEN-->
                                <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                                    <label>IMAGEN</label>
                                    <!-- Solo acepto imagenes jpg -->
                                    <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg" accept="image/png">
                                    <span class="help-block"><?php echo $imagenErr; ?></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!-- Botones -->
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>" />
                    <button type="submit" value="aceptar" class="btn purple-gradient"><i class="fas fa-sync-alt"></i> Modificar</button>
                    <a href="../index.php" class="btn btn-unique"><i class="fas fa-undo-alt"></i> Volver</a>
                </form>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>