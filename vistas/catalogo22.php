<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once VIEW_PATH . "cabecera.php";

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
}
.clear {
    clear: both;
}
.item {
    background-color: #fff;
    float: left;
    margin: 0px 0px 0px 10px;
    width: 205px;
    padding: 50 50 50 50px;
    height: 350px;
}
.item img {
    display: block;
    margin: auto;
    width: 200;
    height: auto;
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
h1.largo{
    width:100%;
    text-align: center;
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

<div class="wrapper">
     <h1 class="largo">Catálogo tienda</h1>
<br><br><br><br>

<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
    <div class="form-group mx-sm-5 mb-2">
        <input type="text" class="form-control" id="buscar" name="producto" placeholder="Nombre o Marca">
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
// Cargamos el controlador de alumnos
$controlador = ControladorProducto::getControlador();

// Parte del paginador
$pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;


//$lista = $controlador->listarAlumnos($nombre, $dni); //-- > Lo hará el paginador

 // Consulta a realizar -- esto lo cambiaré para la semana que viene
 $consulta = "SELECT * FROM productos WHERE nombre LIKE :nombre OR marca LIKE :marca";
 $parametros = array(':nombre' => "%".$nombre."%", ':nombre' => "%".$nombre."%", ':marca' => "%".$marca."%");
 $limite = 10; // Limite del paginador
 $paginador  = new Paginador($consulta, $parametros, $limite);
 $resultados = $paginador->getDatos($pagina);

if(count( $resultados->datos)>0){
    echo "<div class='clear'></div>";
    echo "<div class='items'>";

 

    foreach ($resultados->datos as $l) {
        $producto = new Producto($l->id, $l->nombre, $l->tipo, $l->marca, $l->precio, $l->unidades, $l->imagen);
    echo "<div class='item'>";
    echo "<a href='/tienda/admin/producto/vistas/ficha.php?id=" . encode($producto->getId()) . "' title='Ver Producto' data-toggle='tooltip'>";
    echo "<img src='/tienda/admin/producto/imagen_producto/".$producto->getImagen()."' width='200' height='auto'>";          
    echo    "<h2>" . $producto->getNombre() . "</h2>";
    echo        "</a>&nbsp;&nbsp;";
    echo "<p>Precio: <em>" . $producto->getPrecio() . "€</em></p>";
    echo "<button class='add-to-cart' type='button'>Añadir al carrito</button>";
    echo"</div><br><br><br><br>";
}
    
    echo "</div>";
    echo $paginador->crearLinks($enlaces);
    
} else {
// Si no hay nada seleccionado
    echo "<p class='lead'><em>No se ha encontrado articulos.</em></p>";
}

?>
<!--/ wrapper -->
<?php require_once VIEW_PATH . "pie.php"; ?>
