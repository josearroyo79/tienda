<style>
	/* Made with love by Mutiullah Samim*/

	@import url('https://fonts.googleapis.com/css?family=Numans');

	html,
	body {
		background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg');
		background-size: cover;
		background-repeat: no-repeat;
		height: 100%;
	}

	.container {
		height: 70%;
		align-content: center;
	}

	.card {
		height: 370px;
		margin-top: auto;
		margin-bottom: auto;
		width: 400px;
		background-color: rgba(0, 0, 0, 0.5) !important;
	}

	.social_icon span {
		font-size: 60px;
		margin-left: 10px;
		color: #FFC312;
	}

	.social_icon span:hover {
		color: white;
		cursor: pointer;
	}

	.card-header h3 {
		color: white;
	}

	.social_icon {
		position: absolute;
		right: 20px;
		top: -45px;
	}

	.input-group-prepend span {
		width: 50px;
		background-color: #FFC312;
		color: black;
		border: 0 !important;
	}

	input:focus {
		outline: 0 0 0 0 !important;
		box-shadow: 0 0 0 0 !important;

	}

	.remember {
		color: white;
	}

	.remember input {
		width: 20px;
		height: 20px;
		margin-left: 15px;
		margin-right: 5px;
	}

	.login_btn {
		color: black;
		background-color: #FFC312;
		width: 100px;
	}

	.login_btn:hover {
		color: black;
		background-color: white;
	}

	.links {
		color: white;
	}

	.links a {
		margin-left: 4px;
	}
</style>
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/dirs.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";

//Debemos decir que no estamos identificando
$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();

require_once VIEW_PATH . "cabecera.php";



// Procesamos la indetificación
if (isset($_POST["EMAIL"]) && isset($_POST["password"])) {
	$controlador = ControladorAcceso::getControlador();
	$controlador->procesarIdentificacion($_POST['EMAIL'], $_POST['admin']);
}
?>
<title>Iniciar sesión</title>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Inicio de sesión</h3>
				<!--<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>-->
			</div>
			<div class="card-body">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" required name="email" class="form-control" value="admin@admin.com" placeholder="Usuario">

					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" required value="admin" name="pass" class="form-control" placeholder="Contraseña">
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox">Recordar credenciales
					</div>
					<div class="form-group">
						<input type="submit" value="Entrar" class="btn btn-mdb-color">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					¿No tienes cuenta?<a href="#">Regístrate aquí</a>
				</div>
				<!--<div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div>-->
			</div>
		</div>
	</div>
</div>
<?php require_once VIEW_PATH . "pie.php"; ?>