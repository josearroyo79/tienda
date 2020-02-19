<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!-- Include the above in your HEAD tag -->
<style>
        @import "/tienda/estilos/style_catalogue/style_catalogue.css";
        @import "/tienda/estilos/search/search.css";
</style>
<!--BUSCADOR-->
<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
    <div class="search-box">
		<input id="buscar" name="producto" type="text" class="search-txt" placeholder="Buscar producto">
		<a class="search-btn">
			<i class="fas fa-search"></i>
		</a>
	</div>
</form>
<?php


if (!isset($_POST["producto"])) {
    $nombre = "";
    $marca = "";
} else {
    $nombre = filtrado($_POST["producto"]);
    $marca = filtrado($_POST["producto"]);
}
// Cargamos el controlador de producto y usuarios
$controlador = ControladorProducto::getControlador();

// Parte del paginador
$pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
$enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;

// Consulta a realizar
$consulta = "SELECT * FROM productos WHERE nombre LIKE :nombre OR marca LIKE :marca";
$parametros = array(':nombre' => "%" . $nombre . "%", ':nombre' => "%" . $nombre . "%", ':marca' => "%" . $marca . "%");
$limite = 100; // Limite del paginador
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

if (count($resultados->datos) > 0) {

    echo '<div class="container">';
    echo '<h3 class="h3">CATÁLOGO</h3>';
    echo '<div class="row">';
    foreach ($resultados->datos as $l) {
        $producto = new Producto($l->id, $l->nombre, $l->tipo, $l->marca, $l->precio, $l->unidades, $l->imagen);
        
        echo '<div class="col-md-3 col-sm-6">';
        echo '<div class="product-grid6">';
        echo '<div class="product-image6">';
        echo '<a href="/tienda/admin/producto/vistas/ficha.php?id=' . encode($producto->getId()) . '" data-toggle="tooltip">';
        echo '<img class="pic-1" src="/tienda/admin/producto/imagen_producto/' . $producto->getImagen() . '">';
        echo '</a>';
        echo '</div>';
        echo '<div class="product-content">';
        echo '<h3 class="title"><a href="#">' . $producto->getNombre() . '</a></h3>';
        echo '<div class="price">' . $producto->getPrecio() . ' €';
        //echo '<span>$14.00</span>'; --> PARA PONER DESCUENTO
        echo '</div>';
        echo '</div>';
        echo '<ul class="social">';
        echo '<li><a href="/tienda/admin/producto/vistas/ficha.php?id=' . encode($producto->getId()) . '" data-tip="Ver producto"><i class="fa fa-search"></i></a></li>';
        echo '<li><a href="#" data-tip="Añadir a la lista de deseos"><i class="fa fa-shopping-bag"></i></a></li>';
        echo '<li><a href="/tienda/vistas/añadir_carrito.php?id=' . encode($producto->getId()) . '" data-tip="Añadir al carrito"><i class="fa fa-shopping-cart"></i></a></li>';
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        

    }
    echo '</div>';
    echo '</div>';
    echo '</hr>';
    //echo $paginador->crearLinks($enlaces);
    echo '</br></br></br>';
} else {
    echo "<p class='lead'><em>No se ha encontrado articulos.</em></p>";
}
require_once VIEW_PATH . "pie.php";