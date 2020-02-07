<?php

require_once MODEL_PATH."Producto.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorProducto {
    
    static private $instancia = null;
    
    
    private function __construct() {}

    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorProducto();
        }
        return self::$instancia;
    }

    public function listarProductos($nombre, $marca){
        
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        
        $consulta = "SELECT * FROM productos WHERE nombre LIKE :nombre OR marca LIKE :marca";
        $parametros = array(':nombre' => "%".$nombre."%", ':marca' => "%".$marca."%");
        
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        
        if (count($filas) > 0) {
            foreach ($filas as $l) {
                $producto = new Producto($l->id, $l->nombre, $l->tipo, $l->marca, $l->precio, $l->unidades, $l->imagen);

                $lista[] = $producto;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
    
    public function almacenarProducto($nombre, $tipo, $marca, $precio, $unidades, $imagen){
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
    }
    
    public function buscarProducto($id){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM productos WHERE id = :id";
        $parametros = array(':id' => $id);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $l) {
                $producto = new Producto($l->id, $l->nombre, $l->tipo, $l->marca, $l->precio, $l->unidades, $l->imagen);

                $lista[] = $producto;
            }
            $bd->cerrarBD();
            return $producto;
        }else{
            return null;
        }    
    }

    public function buscarProductoNombre($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM productos WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $l) {
                $producto = new Producto($$l->id, $l->nombre, $l->tipo, $l->marca, $l->precio, $l->unidades, $l->imagen);

                $lista[] = $producto;
            }
            $bd->cerrarBD();
            return $producto;
        }else{
            return null;
        }    
    }
    
    public function borrarProducto($id){ 
        $estado=false;
        
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM productos WHERE id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
    public function actualizarProducto($id, $nombre, $tipo, $marca, $precio, $unidades, $imagen){
       
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "UPDATE productos SET nombre=:nombre, tipo=:tipo, marca=:marca, precio=:precio, unidades=:unidades, imagen=:imagen 
            WHERE id=:id";
        $parametros= array(':id' => $id, ':nombre'=>$nombre, ':tipo'=>$tipo,':marca'=>$marca,
                            ':precio'=>$precio, ':unidades'=>$unidades, ':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
}
