<style>
	@import "/tienda/estilos/style_login/style_login.css";
</style>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/dirs.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";

//Para acceder a la parte del login no podemos estar en una sesión, así que se le llama a la funcion
//salirSesion
$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>

<?php require_once VIEW_PATH . "cabecera.php"; ?>

<?php

// Llamamos a la funcion creada para procesar la información de acceso compuesto por correo + password
if (isset($_POST["correo"]) && isset($_POST["password"])) {
	$controlador = ControladorAcceso::getControlador();
	$controlador->procesarIdentificacion($_POST['correo'], $_POST['password']);
}
?>
<title>Iniciar sesión</title>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Inicio de sesión</h3>
			</div>
			<div class="card-body">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" required name="correo" class="form-control" placeholder="Correo electrónico">

					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" required name="password" class="form-control" placeholder="Contraseña">
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox">Recordar credenciales
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info btn-block my-4">Entrar</button>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					¿No tienes cuenta?<a href="/tienda/vistas/registro.php">Regístrate aquí</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once VIEW_PATH . "pie.php"; ?>