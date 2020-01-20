<?php
require_once MODEL_PATH."Usuario.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorUsuario {

     // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorUsuario();
        }
        return self::$instancia;
    }
    public function listarUsuarios($nombre){
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta pero esta vez paremtrizada
        $consulta = "SELECT * FROM usuarios WHERE nombre LIKE :nombre";
        $parametros = array(':nombre' => "%".$nombre."%");
        // Obtenemos las filas directamente como objetos con las columnas de la tabla
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        //var_dump($filas);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new Usuario($a->id, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->imagen, $a->fecha);
                // Lo añadimos
                $lista[] = $usuario;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }

    public function listarUsuario($id){
        // Creamos la conexión a la BD
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta pero esta vez paremtrizada
        $consulta = "SELECT * FROM usuarios WHERE id LIKE :id";
        $parametros = array(':id' => "%".$id."%");
        // Obtenemos las filas directamente como objetos con las columnas de la tabla
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        //var_dump($filas);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new Usuario($a->id, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->imagen, $a->fecha);
                // Lo añadimos
                $lista[] = $usuario;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
    
    public function almacenarUsuario($nombre, $apellidos, $email, $password, $admin, $telefono, $imagen, $fecha){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO usuarios (nombre, apellidos, email, password,
            admin, telefono, imagen, fecha) VALUES (:nombre, :apellidos, :email, :password, :admin, 
            :telefono, :imagen, :fecha)";
        
        $parametros= array(':nombre'=>$nombre, ':apellidos'=>$apellidos,':email'=>$email, ':password'=>$password,
                            ':admin'=>$admin, ':telefono'=>$telefono,':imagen'=>$imagen,':fecha'=>$fecha);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    public function buscarUsuario($id){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT* FROM usuarios WHERE id = :id";
        $parametros = array(':id' => $id);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new Usuario($a->id, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->imagen, $a->fecha);
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }    
    }

    public function buscarUsuarioNombre($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuarios  WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new Usuario($a->id, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->imagen, $a->fecha);
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }    
    }
    
    public function borrarUsuario($id){ 
        $estado=false;
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM usuarios WHERE id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
    public function actualizarUsuario($id, $nombre, $apellidos, $email, $password, $admin, $telefono, $imagen, $fecha){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, email=:email, password=:password, admin=:admin, 
            telefono=:telefono, imagen=:imagen, fecha=:fecha WHERE id=:id";
        $parametros= array(':id' => $id, ':nombre'=>$nombre, ':apellidos'=>$apellidos,':email'=>$email, ':password'=>$password,
                            ':admin'=>$admin, ':telefono'=>$telefono,':imagen'=>$imagen,':fecha'=>$fecha);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
}
