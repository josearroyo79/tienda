<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";


session_start();
    if (isset($_SESSION['carrito'])){
        $arreglo = $_SESSION['carrito'];
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Tipo</th>";
        echo "<th>Marca</th>";
        echo "<th>Precio</th>";
        echo "<th>Unidades</th>";
        echo "<th>Imagen</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($arreglo as $key => $fila){
            echo "<tr>";
            echo "<td>".$fila['nombre']."</td>";
            echo "<td>De ".$fila['tipo']." Años</td>";
            echo "<td>".$fila['marca']."</td>";
            echo "<td>".$fila['precio']."€</td>";
            echo "<td>".$fila['unidades']."</td>";
            echo "<td><img src='/tienda/admin/producto/imagen_producto/".$imagen."' width='48px' height='48px'></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</ul>";
    } else {
        echo "No hay na";
    }

?>