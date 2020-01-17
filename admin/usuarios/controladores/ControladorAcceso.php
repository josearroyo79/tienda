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

        unset($_SESSION['EMAIL']);

        session_unset();
        session_destroy();
    }
    
    
    public function procesarIdentificacion($email, $admin){
            //$password = hash("sha256",$password);

            // Conexion BBDD
            $bd = ControladorBD::getControlador();
            $bd->abrirBD();
            
            $consulta = "SELECT * FROM usuarios WHERE email=:email and admin=:admin";
            $parametros = array(':email' => $email, ':admin' => $admin);
            
            $res = $bd->consultarBD($consulta,$parametros);
            $filas=$res->fetchAll(PDO::FETCH_OBJ);
            
            if (count($filas) > 0) {
                 
                $_SESSION['EMAIL']['email']=$email;
                
                header("location: ../index.php"); 
                exit();              
            } else {
                echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>ERROR!</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-warning fade in'>";
                                    echo "<p>Lo siento, no tienes permisos de administrador.</p>";
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
