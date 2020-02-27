<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once VIEW_PATH . "cabecera.php";
require_once CONTROLLER_PATH . "ControladorVentas.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";

session_start();
if ((isset($_SESSION['carrito'])) == 0) {
    header("location: /tienda/admin/vistas/error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido</title>
    <style>
        table {
            width: 95%;
        }

        th,
        td {
            width: 25%;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>

<?php
$nombre = $correo = $telefono = $direccion = $nombreTarjeta = $numTarjeta = "";
$nombreErr = $fechaErr = $correoErr = $cvvErr = $telefonoErr = $direccionErr = $nombreTarjetaErr = $numTarjetaErr = "";


$_SESSION['ventas']=[];

    echo $fila['idVenta'] = $_SESSION['ventas'][$ventas->getIdVenta()][0] = $ventas->getId();
    echo $fila['fecha'] = $_SESSION['ventas'][$ventas->getIdVenta()][1] = $ventas->getFecha();
    echo $fila['nombre'] = $_SESSION['ventas'][$ventas->getIdVenta()][2] = $ventas->getNombre();
    echo $fila['correo'] = $_SESSION['ventas'][$ventas->getIdVenta()][3] = $ventas->getPrecio();
    echo $fila['direccion'] = $_SESSION['ventas'][$ventas->getIdVenta()][4] = $ventas->getDireccion();
    echo $fila['nombreTarjeta'] = $_SESSION['ventas'][$ventas->getIdVenta()][5] = $ventas->getNombreTarjeta();
    echo $fila['numTarjeta'] = $_SESSION['ventas'][$ventas->getIdVenta()][6] = $ventas->getNumTarjeta();



if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["pagar"]) {

    $idVenta = filtrado(($_POST["idVenta"]));
    if(empty($nombreVal)){
        $idVentaErr = "Por favor introduzca un id";
    } else{
        $idVenta = $idVentaVal;
    }
 
    $nombre = $_POST["nombre"];
    if (isset($_POST["nombre"]) && !preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s+([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,36}$/iu", $nombre)) {
        $nombreErr = "Introduzca un nombre y apellidos";
    }
    $email = filtrado($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Por favor introduzca email válido.";
    }

    $telefono = filtrado($_POST["telefono"]);
    if (empty($telefono)) {
        $telefonoErr = "Por favor Introduzca un numero de telefono";
    } elseif (!filter_var($telefono, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[0-9]{9}/")))) {
        $telefonoErr = "Por favor intruduzca un teléfono válido";
    }
    $direccion = filtrado(($_POST["direccion"]));
    if (empty($direccion)) {
        $direccionErr = "Por favor introduzca una direccion";
    } else {
        $direccion = $direccion;
    }
    $nombreTarjetaVal = filtrado(($_POST["nombreTarjeta"]));
    if(empty($nombreTarjetaVal)){
        $nombreTarjetaErr = "Por favor introduzca un nombre";
    } else{
        $nombreTarjeta = $nombreTarjetaVal;
    }
    $numTarjetaVal = filtrado(($_POST["numTarjeta"]));
    if(empty($numTarjetaVal)){
        $numTarjetaErr = "Por favor introduzca un nombre";
    } else{
        $numTarjeta = $numTarjetaVal;
    }
            
    $fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
    $hoy = date("d-m-Y", time());
    if(strftime($fecha)<=strftime($hoy)){
        $fechaErr = "La fecha debe ser supeior a la fecha actual";
    }else{
        $fecha = date("d/m/Y", strtotime(filtrado($_POST["fecha"])));
    }



    // AÑADIMOS LOS DATOS DEL PAGO A LA TABLA DE PAGO EN LA BASE DE DATOS
    if (
        empty($fechaErr) && empty($nombreTarjetaErr) && empty($numTarjetaErr) && empty($cvvErr)
    ) {  
        $controladorventa = ControladorVentas::getControlador();
        $estado = $controladorventa->insertarVentas($idVenta, $fecha, $total, $nombre, $correo, $direccion, $nombreTarjeta, $numTarjeta);
        if($estado){
            header("location: ../index.php");
            exit();
        }else{
            header("location: /tienda/admin/vistas/error.php");
            exit();
        }
    }else{
        alerta("Hay errores al procesar el formulario, revise los errores");
    }


        $controlador = ControladorProducto::getControlador();
        $estado = $controlador->actualizarStock($id, $unidades);
        if($estado){
            header("location: ../index.php");
            exit();
        }else{
            header("location: /tienda/admin/vistas/error.php");
            exit();
        }
}
?>

<?php
session_start();

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
                                    echo '</tr>';
                                }
                                ?>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                <hr>
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
<div class="container">
    <div class="row">
        <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <center>
                <h2>Datos de envío</h2>
            </center>
            <hr class="colorgraph">


            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                    <div class="form-group">
                        <input type="text" required name="nombre" pattern="([^\s][A-zÀ-ž\s]+$)" class="form-control input-lg" placeholder="Nombre y primer apellido" tabindex="1">
                        <span class="help-block"><?php echo $nombreErr; ?></span>
                    </div>
                </div>
            



                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($correoErr)) ? 'error: ' : ''; ?>>
                    <input type="email" required name="correo" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control input-lg" placeholder="E-mail" tabindex="3" value="<?php echo $correo; ?>">
                    <span class="help-block"><?php echo $emailErr; ?></span>
                </div>
            </div>
            <div class="row">


                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>>
                    <input type="tel" required name="telefono" class="form-control input-lg" placeholder="Telefono" tabindex="5" pattern="[0-9]{9}" title="Debes poner 9 números">
                    <span class="help-block"><?php echo $telefonoErr; ?></span>
                </div>

 

                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($direccionErr)) ? 'error: ' : ''; ?>>
                    <div class="form-group">
                        <input type="text-area" required name="direccion" class="form-control input-lg" placeholder="calle numero" tabindex="1">
                        <span class="help-block"><?php echo $direccionErr; ?></span>
                    </div>
                </div>
            </div>
            <hr class="colorgraph">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                    <div class="form-group">
                        <input type="text" required name="nombreTarjeta" class="form-control input-lg" placeholder="Titular de la tarjeta" tabindex="1">
                        <span class="help-block"><?php echo $nombreErr; ?></span>
                    </div>
                </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($cvvErr)) ? 'error: ' : ''; ?>>
                    <div class="form-group">
                    <input type="password" name="cv" class="form-control input-lg" autocomplete="off" maxlength="3" pattern="\d{3}" placeholder="Código de seguridad (CVV)" required>
                        <span class="help-block"><?php echo $cvvErr; ?></span>
                    </div>
                </div>
                <hr class="colorgraph">
                <div class="col-xs-12 col-sm-6 col-md-6" <?php echo (!empty($numTarjetaErr)) ? 'error: ' : ''; ?>>
                    <div class="form-group">
                        <input type="text" required name="numTarjeta" class="form-control input-lg" placeholder="Numero de la tarjeta" tabindex="1" minlenght="16" maxlength="16">
                        <span class="help-block"><?php echo $numTarjetaErr; ?></span>
                    </div>
                </div>
            </div>
                <div>
                    <h3><small>Fecha de caducidad de la tarjeta<small></h3>
                    <div class="form-group">
                        <input class="form-horizontal span2" type="date" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha))); ?>"></input>
                        <?php echo $fechaErr; ?> 
                    </div>
                    <hr class="colorgraph">
                </div>

            <!--Botones de redireccionamiento-->
                <div class="col-xs-12 col-md-6"><a href="resumen.php" class="btn btn-dark btn-lg btn-block">Atrás</a></div>
                <div class="col-xs-12 col-md-6"><a href="factura.php" name="pagar" class="btn btn-success btn-lg btn-block" class="btn btn-success btn-block btn-lg" value="aceptar" class="btn btn-success">Aceptar</a></div>
                <!--<div class="col-xs-12 col-md-6"><button type="submit" name="pagar" class="btn btn-success btn-lg btn-block" class="btn btn-success btn-block btn-lg" value="aceptar" class="btn btn-success">Aceptar</button></div>-->
            </div>
        </form>
    </div>
</div>

<br><br>
<?php require_once VIEW_PATH . "pie.php"; ?>


