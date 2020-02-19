<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";


session_start();

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
                                     $imagen = $fila[6];
                                     $total_prod= $fila[4]*$fila[5];
                                     $total=$total_prod;
                                    echo '<a class="thumbnail pull-left" href="#"> <img class="media-object" src="/tienda/admin/producto/imagen_producto/' . $imagen . '" style="width: 72px; height: 72px;"> </a>';
                                    echo '<div class="media-body">';
                                    echo '<h4 class="media-heading">' . $fila[1] . '</h4>';
                                    echo '<h5 class="media-heading"> Marca: ' . $fila[3] . '</h5>';
                                    echo '<span>Estado: </span><span class="text-success"><strong>En stock</strong></span>';
                                    echo "</div>";
                                    echo '</div>';
                                    echo '</td>';
                                    echo '<td class="col-sm-1 col-md-1" style="text-align: center">';
                                    echo '<input type="email" class="form-control" id="exampleInputEmail1" value="1">';
                                    echo '</td>';
                                    echo '<td class="col-sm-1 col-md-1 text-center"><strong>' . $fila[4] . '€</strong></td>';
                                    echo '<td class="col-sm-1 col-md-1 text-center"><strong>'.$total.'€</strong></td>';
                                    echo '<td class="col-sm-1 col-md-1">';
                                    echo '<button type="button" class="btn btn-danger">';
                                    echo '<span class="glyphicon glyphicon-remove"></span> Remove';
                                    echo '</button></td>';
                                    echo '</tr>';
                                } ?>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <h3>Total compra</h3>
                                </td>
                                <td class="text-right">
                                    <h3><strong><?php echo $total ?>€</strong></h3>
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
                                    <a href="#" type="button" class="btn btn-success">
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
    echo "No hay na de na";
}

?>