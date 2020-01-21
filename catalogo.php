<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/producto/dirs.php";
//require_once VIEW_PATH . "cabecera.php";
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
     <h1 align="left">Catálogo tienda</h1>
 <span><i class="shopping-cart"></i></span>
<br><br><br>
    <div class="clear"></div>
    <!-- items -->
    <div class="items">
        <!-- single item -->
        <div class="item">
            <a href="/tienda/admin/producto/vistas/ficha.php?id=MQ%3D%3D">
            <img src="/tienda/admin/producto/imagen_producto/tractor.jpg" width="200px" height="auto" alt="item" />
             <h2>Tractor</h2>
             </a>
            <p>Precio: <em>4,50€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div><br><br><br><br>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="/tienda/admin/producto/vistas/ficha.php?id=Mg%3D%3D">
        <img src="/tienda/admin/producto/imagen_producto/camionbomberos.jpg" width="200px" height="auto" alt="item" />
             <h2>Camión de Bomberos</h2>
        </a>
            <p>Precio: <em>49,99€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="/tienda/admin/producto/vistas/ficha.php?id=Mw%3D%3D">
        <img src="/tienda/admin/producto/imagen_producto/moto.jpg" width="200px" height="auto" alt="item" />
             <h2>Moto</h2>
        </a>
            <p>Precio: <em>106,99€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="/tienda/admin/producto/vistas/ficha.php?id=NA%3D%3D">
        <img src="/tienda/admin/producto/imagen_producto/muñeco.jpg" width="138.5px" height="auto" alt="item" />
             <h2>Muñeco BabyBoom</h2>
        </a>
            <p>Precio: <em>9,99€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="/tienda/admin/producto/vistas/ficha.php?id=NQ%3D%3D">
        <img src="/tienda/admin/producto/imagen_producto/oso.jpg" width="200px" height="auto" alt="item" />
             <h2>Oso de Peluche</h2>
        </a>
            <p>Precio: <em>2€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
        <!--/ single item -->
        <!-- single item -->
        <div class="item">
        <a href="/tienda/admin/producto/vistas/ficha.php?id=Ng%3D%3D">
        <img src="/tienda/admin/producto/imagen_producto/monopoly.jpg" width="200px" height="auto" alt="item" />
             <h2>Monopoly</h2>
        </a>
            <p>Precio: <em>19,99€</em>
            </p>
            <button class="add-to-cart" type="button">Añadir al carrito</button>
        </div>
    </div>
    <!--/ items -->
</div>
<!--/ wrapper -->
<?php //require_once VIEW_PATH . "pie.php"; ?>