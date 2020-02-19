<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";

$id = decode($_GET["id"]);
$controlador = ControladorProducto::getControlador();
$producto = $controlador->buscarProducto($id);
if (!is_null($producto)) {
    $nombre = $producto->getNombre();
    $tipo = $producto->getTipo();
    $marca = $producto->getMarca();
    $precio = $producto->getPrecio();
    $unidades = $producto->getUnidades();
    $imagen = $producto->getImagen();
    $imagenAnterior = $imagen;
}
if (!isset($_SESSION['carrito'])) {

    $_SESSION['carrito'] = [];
}
$unidad_inicial = 1;

echo $fila['id'] = $_SESSION['carrito'][$producto->getId()][0] = $producto->getId();
echo $fila['nombre'] = $_SESSION['carrito'][$producto->getId()][1] = $producto->getNombre();
echo $fila['tipo'] = $_SESSION['carrito'][$producto->getId()][2] = $producto->getTipo();
echo $fila['marca'] = $_SESSION['carrito'][$producto->getId()][3] = $producto->getMarca();
echo $fila['precio'] = $_SESSION['carrito'][$producto->getId()][4] = $producto->getPrecio();
echo $fila['unidades'] = $_SESSION['carrito'][$producto->getId()][5] = $producto->getUnidades();
echo $fila['imagen'] = $_SESSION['carrito'][$producto->getId()][6] = $producto->getImagen();
$_SESSION['carrito'][$producto->getId()][6] = $unidad_inicial;
//print_r($_SESSION['carrito']);
header('Location:/tienda/vistas/catalogo.php');
