<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";

session_start();
if (!isset($_SESSION['USUARIO']['correo'])) {
    header("location: /tienda/login.php");
    exit();
}

if (isset($_SESSION['carrito'])) {
    $arreglo = $_SESSION['carrito'];
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Total producto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($arreglo as $key => $fila) {
                        ?>
                            <tr>
                                <td class="col-sm-8 col-md-6">
                                    <div class="media">
                                    <?php
                                    $id = $fila[0];
                                    $nombre = $fila[1];
                                    $marca = $fila[3];
                                    $precio = $fila[4];
                                    $unidades = $fila[5];
                                    $imagen = $fila[6];
                                   
                                    $total=$fila[7]*$fila[4];
                                    $total_compra +=  $total;
                                    echo '<a class="thumbnail pull-left" href="#"> <img class="media-object" src="/tienda/admin/producto/imagen_producto/'.$imagen.'" style="width: 72px; height: 72px;"/> </a>';
                                    echo '<div class="media-body">';
                                    echo '<h4 class="media-heading">' . $nombre . '</h4>';
                                    echo '<h5 class="media-heading"> Marca: ' . $marca . '</h5>';
                                    echo '<span>Stock: </span><strong>'.$unidades.'</strong>';
                                    echo "</div>";
                                    echo '</div>';
                                    echo '</td>';
                                    echo '<td class="col-sm-1 col-md-1" style="text-align: center">';
                                    echo '<input disabled type="number" class="form-control" value="' . $fila[7] .'">';
                                    echo '</td>';
                                    echo '<td class="col-sm-1 col-md-1 text-center"><strong>' . $precio . '€</strong></td>';
                                    echo '<td class="col-sm-1 col-md-1 text-center"><strong>'.$total.'€</strong></td>';
                                    echo '<td class="col-sm-1 col-md-1">';
                                    echo '<a href="/tienda/vistas/borrar_carrito.php?id=' . encode($id) . '" type="button" class="btn btn-danger">';
                                    echo '<span class="glyphicon glyphicon-remove"></span> Borrar producto';
                                    echo '</a></td>';
                                    echo '</tr>';
                                }
                                ?>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <h3>Total compra</h3>
                                </td>
                                <td class="text-right">
                                    <h3><strong><?php echo $total_compra ?>€</strong></h3>
                                </td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <a href="/tienda/index.php" type="button" class="btn btn-default">
                                        <span class="glyphicon glyphicon-shopping-cart"></span> Continuar comprando
                                    </a></td>
                                <td>
                                    <a href="/tienda/vistas/resumen.php" type="button" class="btn btn-success">
                                        Pagar <span class="glyphicon glyphicon-play"></span>
                                    </a></td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
} else {
    ?>
    <style>
    .no_carrito{
        margin-left:30%;
        width: 500px;
    }
    </style>
    <h3 align="center">El carrito está vacío, llénelo.</h3></br>
    <img class="no_carrito" src="/tienda/admin/imagenes/no_carrito.png" alt="Carrito vacío :(">
    <?php
}

?>