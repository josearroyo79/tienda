<?php

require_once CONTROLLER_PATH."ControladorBD.php";

class ControladorAcceso {
    static private $instancia = null;

    private function __construct() {
        //echo "Conector creado";
    }

    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAcceso();
        }
        return self::$instancia;
    }
    
    public function salirSesion() {
        session_start();

        unset($_SESSION['USUARIO']);

        session_unset();
        session_destroy();
    }
    
    
    public function procesarIdentificacion($email, $password){
            $password = hash("sha256",$password);

            // Conexion BBDD
            $bd = ControladorBD::getControlador();
            $bd->abrirBD();
            
            $consulta = "SELECT * FROM usuarios WHERE email=:email and password=:password";
            $parametros = array(':email' => $email, ':password' => $password);
            
            $res = $bd->consultarBD($consulta,$parametros);
            $filas=$res->fetchAll(PDO::FETCH_OBJ);
            
            if (count($filas) > 0) {
                 
                $_SESSION['USUARIO']['email']=$email;
                
                header("location: ../index.php"); 
                exit();              
            } else {
                echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Usuario/a incorrecto</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-warning fade in'>";
                                    echo "<p>Lo siento, el email o password es incorrecto. Por favor <a href='login.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                // Pie web
                require_once VIEW_PATH."pie.php";
                exit();
            }
    }
}
