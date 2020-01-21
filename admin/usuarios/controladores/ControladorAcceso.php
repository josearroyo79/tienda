<?php

require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorAcceso
{
    static private $instancia = null;

    private function __construct()
    {
        //echo "Conector creado";
    }

    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAcceso();
        }
        return self::$instancia;
    }

    public function salirSesion()
    {
        session_start();

        unset($_SESSION['email']);

        session_unset();
        session_destroy();
    }


    public function procesarIdentificacion($email, $password)
    {
        //$password = hash("sha256", $password);

        // Conexion BBDD
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "SELECT * FROM usuarios WHERE email=:email and password=:password";
        $parametros = array(':email' => $email, ':password' => $password);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {

            $_SESSION['email']['email'] = $email;

            header("location: /tienda/admin/index.php");
            exit();
        } else {
            echo "<h1>ERROR!</h1>";
            // Pie web
            require_once VIEW_PATH . "pie.php";
            exit();
        }
    }
}
