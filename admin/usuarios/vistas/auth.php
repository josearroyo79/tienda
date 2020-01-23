<?php
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
session_start();
if (!isset($_SESSION['USUARIO']['correo'])) {
    header("location: /tienda/login.php");
    exit();
}
if (!isset($_SESSION['USUARIO']['correo']) || ($_SESSION['USUARIO']['correo']) != "admin@admin.com") {
    header("location: /tienda/admin/vistas/error.php");
    exit();
} else {
    header("location: listado.php");
    exit();
}
?>