<!-- Cabecera de la página web -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/dirs.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";

//Debemos decir que no estamos identificando
$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>

<?php require_once VIEW_PATH . "cabecera.php"; ?>
<!-- Barra de Navegacion -->

<?php

// Procesamos la indetificación
if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $controlador = ControladorAcceso::getControlador();
    $controlador->procesarIdentificacion($_POST['email'], $_POST['pass']);
}
?>


<!-- Cuerpo de la página web -->

<!-- Default form login -->
<form class="text-center border border-light p-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <p class="h4 mb-4">Identificación de usuario/a:</p>
                    <!-- Usuario -->
                    <div class="form-group">
                        <input type="text" required name="email" class="form-control mb-4" value="admin@admin.com" placeholder="Usuario">
                    </div>
                    <!-- Contraseña -->
                    <div class="form-group">
                        <input type="password" id="defaultLoginFormPassword" required value="admin" name="pass" class="form-control mb-4" placeholder="Contraseña">
                    </div>
    <!-- Botones -->
    <button type="submit" class="btn btn-info btn-block my-4">Entrar</button>
    <a href="/tienda/admin/index.php" class="btn btn-danger btn-block my-4">Cancelar</a>

</form>
<br>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>