<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";

$id = decode($_GET["id"]);
$controlador = ControladorProducto::getControlador();
$producto = $controlador->buscarProducto($id);

$venta = new Venta($idVenta, "", $total, round(($total / 1.21), 2),
        round(($total - ($total / 1.21)), 2),
        $nombre, $correo, $direccion, $nombreTarjeta, $numeroTarjeta);

    $cv = ControladorVentas::getControlador();
    if ($cv->insertarVentas($venta)) {
        alerta("Venta procesada", "/tienda/vistas/carrito_factura.php?venta=" . encode($idVenta));
        exit();
    } else {
        alerta("Existe un error al procesar la venta");
    }
