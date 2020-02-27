<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT']."/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once UTILITY_PATH . "funciones.php";
//require_once VIEW_PATH . "../cabecera.php";
session_start();
if (isset($_SESSION['ventas']) & $_SESSION['carrito']) {
  $arreglo = $_SESSION['ventas'] & $_SESSION['carrito'];
}
// Solo entramos si somos el usuario y hay items
/*if ((!isset($_SESSION['USUARIO']['email']) || $_SESSION['carrito'] != 0)) {
    header("location: /tienda/admin/vistas/error.php");
    exit();
}*/

//Vaciamos las sesiones que utilizamos en la compra una vez que se ha terminado todo el tramite del carrito
if (isset($_POST['finalizar'])) {
alerta("Gracias por confiar y realizar su compra con nosotros");
$_SESSION['carrito']=[];
$_SESSION['ventas']=[];
redir("/tienda/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Factura</title>
  </head>
  <body class="centro">
    <header class="clearfix">
      <div id="company">
        <h2 class="name">Jugueteria</h2>
        <div>Calle Jerusalen nº14 s/n</div>
        <div>+34 60585369</div>
        <div><a href="mailto:juguete@factura.com">juguete@factura.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
                    <h3 class="pull-right">Numero de pedido: <?php
                $fecha2 = new DateTime;
                echo $fecha2->format('Ydm'). $_SESSION['id']++; 
            ?></h3>
        </div>
        <div id="invoice">
        <strong>Facturado a:</strong><br>
        <h3 class="pull-right">Numero de pedido: <?php echo $_SESSION['ventas']['idVenta']; ?></h3>
            <?php echo $fila[3]; ?><br> 
            <?php echo $_SESSION['correo']; ?><br>
            <?php echo $_SESSION['direccion']; ?><br>
            <strong>Método de pago:</strong><br>
            Tarjeta de crédito/debito: ****************<br>
            <strong>Fecha de compra:</strong><br>
            <?php
                $fecha2 = new DateTime;
                echo $fecha2->format('d/m/Y'); 
            ?>
        </div>
      </div>
      <hr>


      <?php

if (isset($_SESSION['carrito'])) {
    $arreglo = $_SESSION['carrito'];
?>
    <div class="container">
        <div>
            <div>
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
                                    echo "</div>";
                                    echo '</div>';
                                    echo '</td>';
                                    echo '<td class="col-sm-1 col-md-1" style="text-align: center">';
                                    echo '<input disabled type="number" class="form-control" value="' . $fila[7] .'">';
                                    echo '</td>';
                                    echo '<td class="col-sm-1 col-md-1 text-center"><strong>' . $precio . '€</strong></td>';
                                    echo '<td class="col-sm-1 col-md-1 text-center"><strong>'.$total.'€</strong></td>';
                                    echo '<td class="col-sm-1 col-md-1">';
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
}

?>
   <?php
            echo "<a href='/tienda/utilidades/descargar.php?opcion=FACTURA&id=".encode($_SESSION['idVenta']). " ' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-download'></span>  PDF</a>";
            ?>
  
        <h2>GRACIAS POR SU COMPRA</h2>
</main>
