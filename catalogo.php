<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/producto/dirs.php";
// Incluimos los ficheros que ncesitamos
// Incluimos los directorios a trabajar
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once UTILITY_PATH."funciones.php";
// creamos la consulta dependiendo si venimos o no del formulario
// para el buscador: select * from alumnado where nombre like "%%" or apellidos like "%%"
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
$pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;


//$lista = $controlador->listarAlumnos($nombre, $dni); //-- > Lo hará el paginador

 // Consulta a realizar -- esto lo cambiaré para la semana que viene
 $consulta = "SELECT * FROM productos WHERE nombre LIKE :nombre OR marca LIKE :marca";
 $parametros = array(':nombre' => "%".$nombre."%", ':nombre' => "%".$nombre."%", ':marca' => "%".$marca."%");
 $limite = 4; // Limite del paginador
 $paginador  = new Paginador($consulta, $parametros, $limite);
 $resultados = $paginador->getDatos($pagina);


// Si hay filas (no nulo), pues mostramos la tabla
//if (!is_null($lista) && count($lista) > 0) {
if(count( $resultados->datos)>0){
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nombre</th>";
    echo "<th>Tipo</th>";
    echo "<th>Marca</th>";
    echo "<th>Precio</th>";
    echo "<th>Unidades</th>";
    echo "<th>Imagen</th>";
    echo "<th>Acción</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    // Recorremos los registros encontrados
    foreach ($resultados->datos as $l) {
    //foreach ($lista as $alumno) {
        // Esto lo hago para no cambiaros el resto de codigo, si no podría usar a directamente
        $producto = new Producto($l->id, $l->nombre, $l->tipo, $l->marca, $l->precio, $l->unidades, $l->imagen);
        // Pintamos cada fila
        echo "<tr>";
        echo "<td>" . $producto->getNombre() . "</td>";
        echo "<td>" . $producto->getTipo() . "</td>";
        echo "<td>" . $producto->getMarca() . "</td>";
        echo "<td>" . $producto->getPrecio() . "€</td>";
        echo "<td>" . $producto->getUnidades() . "</td>";
        echo "<td><img src='imagen_producto/".$producto->getImagen()."' width='48px' height='48px'></td>";
        echo "<td>";
        echo "<a href='vistas/read.php?id=" . encode($producto->getId()) . "' title='Ver Alumno/a' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
        echo "<a href='vistas/update.php?id=" . encode($producto->getId()) . "' title='Actualizar Alumno/a' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
        echo "<a href='/tienda/admin/producto/vistas/delete.php?id=" . encode($producto->getId()) . "' title='Borar Producto' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo $paginador->crearLinks($enlaces);
    echo "</ul>";
} else {
    // Si no hay nada seleccionado
    echo "<p class='lead'><em>No se ha encontrado articulos.</em></p>";
}
?>
<!------ Include the above in your HEAD tag ---------->
<style>
.wrapper {
    width: 705px;
    margin: 20px auto;
    padding: 20px;
}
h1 {
    display: inline-block;
    background-color: #333;
    color: #fff;
    font-size: 20px;
    font-weight: normal;
    text-transform: uppercase;
    padding: 4px 20px;
    float: left;
}
.clear {
    clear: both;
}
.item {
    background-color: #fff;
    float: left;
    margin: 0px 10px 10px 0px;
    width: 205px;
    padding: 10px;
    height: 350px;
}
.item img {
    display: block;
    margin: auto;
}
h2 {
    font-size: 16px;
    display: block;
    border-bottom: 1px solid #ccc;
    margin: 0 0 10px 0;
    padding: 0 0 5px 0;
}
button {
    border: 1px solid #722A1B;
    padding: 4px 14px;
    background-color: #fff;
    color: #722A1B;
    text-transform: uppercase;
    float: right;
    margin: 5px 0;
    font-weight: bold;
    cursor: pointer;
}
span {
    float: right;
}
.shopping-cart {
    display: inline-block;
    background: url('http://cdn1.iconfinder.com/data/icons/jigsoar-icons/24/_cart.png') no-repeat 0 0;
    width: 24px;
    height: 24px;
    margin: 0 10px 0 0;
}
</style>
<script>
$('.add-to-cart').on('click', function () {
        var cart = $('.shopping-cart');
        var imgtodrag = $(this).parent('.item').find("img").eq(0);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            
            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
        }
    });
</script>

<!-- wrapper -->
<div class="wrapper">
     <h1>Catálogo tienda</h1>
 <span><i class="shopping-cart"></i></span>

    <div class="clear"></div>
    <!-- items -->
    <div class="items">
        <!-- single item -->
        <div class="item">
            <a href="item1">
            <img src="http://img.tjskl.org.cn/pic/z2577d9d-200x200-1/pinarello_lungavita_2010_single_speed_bike.jpg" alt="item" />
             <h2>Item 1</h2>
             </a>
            <p>Precio: <em>500€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="item2">
            <img src="http://img.tjskl.org.cn/pic/z2577d9d-200x200-1/pinarello_lungavita_2010_single_speed_bike.jpg" alt="item" />
             <h2>Item 2</h2>
        </a>
            <p>Precio: <em>550€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="item3">
            <img src="http://img1.exportersindia.com/product_images/bc-small/dir_55/1620613/cannondale-jekyll-1-2011-mountain-bike-309779.jpg" alt="item" />
             <h2>Item 3</h2>
        </a>
            <p>Precio: <em>700€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="item4">
            <img src="http://img1.exportersindia.com/product_images/bc-small/dir_55/1620613/cannondale-jekyll-1-2011-mountain-bike-309779.jpg" alt="item" />
             <h2>Item 4</h2>
        </a>
            <p>Precio: <em>800€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="item4">
            <img src="http://img1.exportersindia.com/product_images/bc-small/dir_55/1620613/cannondale-jekyll-1-2011-mountain-bike-309779.jpg" alt="item" />
             <h2>Item 4</h2>
        </a>
            <p>Precio: <em>800€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="item4">
            <img src="http://img1.exportersindia.com/product_images/bc-small/dir_55/1620613/cannondale-jekyll-1-2011-mountain-bike-309779.jpg" alt="item" />
             <h2>Item 4</h2>
        </a>
            <p>Precio: <em>800€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="item4">
            <img src="http://img1.exportersindia.com/product_images/bc-small/dir_55/1620613/cannondale-jekyll-1-2011-mountain-bike-309779.jpg" alt="item" />
             <h2>Item 4</h2>
        </a>
            <p>Precio: <em>800€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
    </div>
    <!--/ items -->
</div>
<!--/ wrapper -->
<?php //require_once VIEW_PATH . "pie.php"; ?>