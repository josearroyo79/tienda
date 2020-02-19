<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorImagenUser.php";
require_once UTILITY_PATH . "funciones.php";


$nombre = $apellidos = $correo = $password = $telefono = $imagen = "";
$nombreErr = $apellidosErr = $correoErr = $passwordErr = $telefonoErr = $imagenErr = "";
$imagenAnterior = "";

$errores = [];

session_start();

//Cogemos la id de sesión del usuario actual y la almaceno en una variable para ser comparada
$idUsuario = encode($_SESSION['id']);
//Almaceno en la variable identificadorURI el identificador de url que se está pasando
$identificadorURI = $_SERVER["REQUEST_URI"];
//Si el id de la url es igual que el id de la sesión del usuario, accede, no le digo nada, sino, error
//porque significa que el id de la url es distinto al de la sesión por lo que es otro usuario accediendo a otra vista.
if ($identificadorURI == "/tienda/vistas/perfil.php?id=$idUsuario") {
} else {
    header('location: /tienda/admin/vistas/error.php');
}

// Procesamos la información obtenida por POST
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

    /// Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if (empty($nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre";
    } else {
        $nombre = $nombreVal;
    }

    // Procesamos apellido
    $apellidos = filtrado($_POST["apellidos"]);

    // Procesamos el correo
    // Buscamos que no exista el correo exactamente igual que el nombre
    $correoVal = filtrado($_POST["correo"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarusuario($id);

    $correoactual = $usuario->getCorreo();

    if (empty($correoVal)) {
        $correoErr = "El campo de correo está vacío o no es válido";
    } else if ($correoVal == $correoactual) {
        $correo = $correoVal;
    } else {
        $usuario = $controlador->buscarUsuarioCorreo($correoVal);
        if (isset($usuario)) {
            $correoErr = '¡ERR0R! ----- El correo "' . $correoVal . '" ya está registrado en esta web.';
        } else {
            $correo = $correoVal;
        }
    }

    // Procesamos la contraseña
    $passwordVal = filtrado($_POST["password"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarusuario($id);

    if (empty($passwordVal)) {
        $password = $usuario->getPassword();
    } else {
        $password = hash('sha256', $passwordVal);
    }

    //Procesamos el teléfono
    $telefono = filtrado($_POST["telefono"]);

    // Procesamos la imagen
    if ($_FILES['imagen']['size'] > 0 && count($errores) == 0) {
        $propiedades = explode("/", $_FILES['imagen']['type']);
        $extension = $propiedades[1];
        $tam_max = 5000000; // 5 MB
        $tam = $_FILES['imagen']['size'];
        $mod = true;

        if ($extension != "jpg" && $extension != "jpeg" && $extension != "png") {
            $mod = false;
            $imagenErr = "Formato debe ser jpg/jpeg/png";
        }

        if ($tam > $tam_max) {
            $mod = false;
            $imagenErr = "Tamaño superior al limite de: " . ($tam_max / 1000) . " KBytes";
        }

        if ($mod) {
            $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'] . time()) . "." . $extension;
            $controlador = ControladorImagen::getControlador();
            if (!$controlador->salvarImagen($imagen)) {
                $imagenErr = "Error al procesar la imagen y subirla al servidor";
            }

            // Borramos la antigua imagen
            $imagenAnterior = trim($_POST["imagenAnterior"]);
            if ($imagenAnterior != $imagen) {
                if (!$controlador->eliminarImagen($imagenAnterior)) {
                    $imagenErr = "Error al borrar la antigua imagen en el servidor";
                }
            }
        } else {
            // Si no la hemos modificado, cogemos la imagen que ya estaba
            $imagen = trim($_POST["imagenAnterior"]);
        }
    } else {
        $imagen = trim($_POST["imagenAnterior"]);
    }


    // Chequeamos los errores antes de insertar en la base de datos
    if (
        empty($nombreErr) && empty($apellidosErr) && empty($correoErr) && empty($passwordErr) &&
        empty($telefonoErr) && empty($imagenErr)
    ) {
        $controlador = ControladorUsuario::getControlador();
        $estado = $controlador->actualizarPerfil($id, $nombre, $apellidos, $correo, $password, $telefono, $imagen);
        if ($estado) {
            $errores = [];
            header("location: ../index.php");
            exit();
        } else {
            header("location: /tienda/admin/vistas/error.php");
            exit();
        }
    }
}

// Comprobamos que existe el id antes de ir más lejos
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id =  decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuario($id);
    if (!is_null($usuario)) {
        $id = $usuario->getId();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $correo = $usuario->getCorreo();
        $password = $usuario->getPassword();
        $telefono = $usuario->getTelefono();
        $imagen = $usuario->getImagen();
        $imagenAnterior = $imagen;
    } else {
        header("location: error.php");
        exit();
    }
} else {
    header("location: error.php");
    exit();
}

?>

<?php require_once VIEW_PATH . "cabecera.php"; ?>

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
                                    <input placeholder="Nombre" required name="nombre" type="text" id="inputPlaceholderEx" class="form-control" value="<?php echo $nombre = $usuario->getNombre(); ?>" pattern="([^\s][A-zÀ-ž\s]+)" title="El nombre no puede contener números" minlength="3">
                                    <span class="help-block"><?php echo $nombreErr; ?></span>
                                </div>
                            </td>
                            <!-- IMAGEN -->
                            <td>
                                <b><label>IMAGEN</label></b><br>
                                <img src='<?php echo "/tienda/admin/usuarios/imagenes/" . $usuario->getImagen() ?>' class='rounded' class='img-thumbnail' width='150' height='auto'>
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
                                <!-- CONTRASEÑA -->
                                <div class="form-group <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                                    <b><label>CONTRASEÑA</label></b>
                                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" minlength="1">
                                    <span class="help-block"><?php echo $passwordErr; ?></span>
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
                                    <!-- Solo acepto imagenes jpeg y png -->
                                    <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg, image/png">
                                    <span class="help-block"><?php echo $imagenErr; ?></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!-- BOTONES -->
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
<?php require_once VIEW_PATH . "pie.php"; ?>