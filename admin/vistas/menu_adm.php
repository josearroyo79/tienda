<style>
    @import '/tienda/estilos/menu_adm/menu_adm.css';
</style>
<?php
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
session_start();
if (!isset($_SESSION['USUARIO']['correo'])) {
    header("location: /tienda/login.php");
    exit();
} else if ($_SESSION['tipo'] != "ADMIN") {
    header("location: vistas/error.php");
    exit();
}
?>
<a id='adm' href='producto/index.php'><div id='adm' class="btn from-middle">Administrar productos</div></a>
<a id="adm" href="usuarios/index.php"><div id='adm' class="btn from-left">Administrar usuarios</div></a>
<a id="adm" href="../index.php"><div id='adm' class="btn from-right">Administrar catalogo</div></a>
<a id="adm" href="#"><div id='adm' class="btn from-bottom">Cerrar sesión</div></a>
<br><br><br>