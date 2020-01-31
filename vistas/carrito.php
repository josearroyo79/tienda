<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";


if (!isset($_POST["producto"])) {
    $nombre = "";
    $marca = "";
} else {
    $nombre = filtrado($_POST["producto"]);
    $marca = filtrado($_POST["producto"]);
}
// Cargamos el controlador de alumnos
$controlador = ControladorProducto::getControlador();

// Parte del paginador
$pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
$enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;

$cantidad = $value[1];

//$lista = $controlador->listarAlumnos($nombre, $dni); //-- > Lo hará el paginador

// Consulta a realizar -- esto lo cambiaré para la semana que viene
$consulta = "SELECT * FROM productos WHERE nombre LIKE :nombre OR marca LIKE :marca";
$parametros = array(':nombre' => "%" . $nombre . "%", ':nombre' => "%" . $nombre . "%", ':marca' => "%" . $marca . "%");
$limite = 10; // Limite del paginador
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

if (count($resultados->datos) > 0) {

echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-sm-12 col-md-10 col-md-offset-1">';
    echo '<table class="table table-hover">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Producto</th>';
    echo '<th>Cantidad</th>';
    echo '<th class="text-center">Precio</th>';
    echo '<th class="text-center">Total</th>';
    echo '<th> </th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($resultados->datos as $l) {
        $producto = new Producto($l->id, $l->nombre, $l->tipo, $l->marca, $l->precio, $l->unidades, $l->imagen);
    echo '<tr>';
    echo '<td class="col-sm-8 col-md-6">';
    echo '<div class="media">';
    echo '<a class="thumbnail pull-left" href="#"> <img class="media-object" src="/tienda/admin/producto/imagen_producto/' . $producto->getImagen() .  '" width="200px" height="auto"></a>';
    echo '<div class="media-body">';
    echo '<h4 class="media-heading"><a href="#">' . $producto->getNombre() . '</a></h4>';
    echo '<h5 class="media-heading"> by <a href="#">' . $producto->getMarca() . '</a></h5>';
    echo '</div>';
    echo '</div></td>';
    echo '<td class="col-sm-1 col-md-1" style="text-align: center">';
    echo '<input type="number" class="form-control" value="<?php echo $cantidad; ?>" onchange="submit()"  ';
    echo '</td>';
    echo '<td class="col-sm-1 col-md-1 text-center"><strong>' . $producto->getPrecio() . '€</strong></td>';
    echo '<td class="col-sm-1 col-md-1 text-center"><strong>' . ($producto->getPrecio()*$cantidad) . '€</strong></td>';
    echo '<td class="col-sm-1 col-md-1">';
    echo '<button type="button" class="btn btn-danger">';
    echo '<span class="glyphicon glyphicon-remove"></span> Borrar';
    echo '</button></td>';
    echo '</tr>';
    }
    echo '<tr>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td><h5>Subtotal</h5></td>';
    echo '<td class="text-right"><h5><strong>$24.59</strong></h5></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td><h5>IVA</h5></td>';
    echo '<td class="text-right"><h5><strong>$6.94</strong></h5></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td><h3>Total</h3></td>';
    echo '<td class="text-right"><h3><strong>$31.53</strong></h3></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td>   </td>';
    echo '<td>';
    echo '<button type="button" class="btn btn-default">';
    echo '<span class="glyphicon glyphicon-shopping-cart"></span> Continuar comprando';
    echo '</button></td>';
    echo '<td>';
    echo '<button type="button" class="btn btn-success">';
    echo 'Finalizar compra <span class="glyphicon glyphicon-play"></span>';
    echo '</button></td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}else {
        echo "<p class='lead'><em>Carrito vacío</em></p>";
    }
?><br><br>
<?php require_once VIEW_PATH . "pie.php";?>