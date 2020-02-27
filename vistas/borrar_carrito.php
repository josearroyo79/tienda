<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";

$id = decode($_GET["id"]);
$controlador = ControladorProducto::getControlador();
$producto = $controlador->buscarProducto($id);

if(array_key_exists($producto->getId(), $_SESSION['carrito'])){
    unset($_SESSION['carrito'][$producto->getId()]);
}
header('location: /tienda/vistas/carrito.php');