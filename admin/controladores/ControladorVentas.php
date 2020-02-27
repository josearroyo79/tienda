<?php
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."Ventas.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once UTILITY_PATH."funciones.php";
require_once MODEL_PATH."Usuario.php";


class ControladorVentas {
    static private $instancia = null;
    
    
    private function __construct() {}

    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorVentas();
        }
        return self::$instancia;
    }
    public function insertarVentas($venta){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO ventas (idVenta, fecha, total, nombre, correo, direccion, 
                    nombreTarjeta, numTarjeta) VALUES (:idVenta, :fecha, :total, :nombre, :correo, :direccion, 
                    :nombreTarjeta, :numTarjeta)";

        $parametros = array(':idVenta' => $idventa->getIdVenta(), ':fecha' => $fecha->getFecha(), ':total' => $total->getTotal(),
            ':nombre' => $nombre->getNombre(),
            ':correo' => $correo->getCorreo(), ':direccion' => $direccion->getDireccion(), ':nombreTarjeta' => $nombreTarjeta->getNombreTarjeta(),
            'numTarjeta' => $numTarjeta->getNumTarjeta());

        $estado = $conexion->actualizarBD($consulta, $parametros);
        $conexion->cerrarBD();
    
   /* public function almacenarProducto($nombre, $tipo, $marca, $precio, $unidades, $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO productos (nombre, tipo, marca, 
            precio, unidades, imagen) VALUES (:nombre, :tipo, :marca, :precio, :unidades, 
            :imagen)";
        
        $parametros= array(':nombre'=>$nombre, ':tipo'=>$tipo,':marca'=>$marca,
                            ':precio'=>$precio, ':unidades'=>$unidades, ':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }*/

    

        // Procesamos cada línea del carrito
        foreach ($_SESSION['carrito'] as $key => $fila) {
            if (($fila[0] != null)) {
                $producto = $fila[0];
                $unidades = $fila[1];

                $conexion->abrirBD();

                $consulta = "INSERT INTO productos (nombre, tipo, marca, 
                precio, unidades, imagen) VALUES (:nombre, :tipo, :marca, :precio, :unidades, 
                :imagen)";
                $parametros= array(':nombre'=>$nombre, ':tipo'=>$tipo,':marca'=>$marca,
                ':precio'=>$precio, ':unidades'=>$unidades, ':imagen'=>$imagen);

                $estado = $conexion->actualizarBD($consulta, $parametros);

                // Actualizo el stock
                $cp = ControladorProducto::getControlador();
                $estado = $cp->actualizarStock($producto->getId(), ($producto->getUnidades() - $unidades));

                $conexion->cerrarBD();
            }
        }
        return $estado;
    }
}

?>