<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";

$id = decode ($_GET["id"]);
$controlador = ControladorProducto::getControlador();
$producto = $controlador->buscarProducto($id);

// Consulta a realizar
$consulta = "SELECT * FROM productos WHERE id LIKE :id";
$parametros = array(':id' => "%" . $id . "%");
$limite = 100; // Limite del paginador
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

if (count($resultados->datos) > 0) {

if (!isset ($_SESSION['carrito'])){

    $arreglo[0]['id']=$fila['id'];
    $arreglo[0]['nombre']=$fila['nombre'];

    $arreglo[0]['cliente']=$_SESSION['usuario'];
    $arreglo[0]['fecha']=date('Y-m-d h:m');

    $arreglo[0]['tipo']=$fila['tipo'];
    $arreglo[0]['marca']=$fila['marca'];
    $arreglo[0]['precio']=$fila['precio'];
    $arreglo[0]['cantidad']=1;
    $_SESSION['carrito']=$arreglo;
} else {
    $arreglo = $_SESSION['carrito'];
    $cant=count($arreglo);
    
    $arreglo[$cant+1]['id']=$fila['id'];
    $arreglo[$cant+1]['nombre']=$fila['nombre'];

    $arreglo[$cant+1]['cliente']=$_SESSION['usuario'];
    $arreglo[$cant+1]['fecha']=date('Y-m-d h:m');

    $arreglo[$cant+1]['tipo']=$fila['tipo'];
    $arreglo[$cant+1]['marca']=$fila['marca'];
    $arreglo[$cant+1]['precio']=$fila['precio'];
    $arreglo[$cant+1]['cantidad']=1;
    $_SESSION['carrito']=$arreglo;
}
}
print_r($_SESSION['carrito']);
header('Location:/tienda/vistas/catalogo.php')
?>