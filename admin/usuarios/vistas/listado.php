<?php
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
session_start();
if (!isset($_SESSION['USUARIO']['correo'])) {
    header("location: /tienda/login.php");
    exit();
} else if ($_SESSION['tipo'] != "ADMIN") {
    header("location: /tienda/admin/vistas/error.php");
    exit();
}
?>
<style>
    @import "/tienda/estilos/style_buttons/style_buttons.css";
    @import "/tienda/estilos/search/search.css";
    @import "/tienda/estilos/style_listado/style_listado.css";
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header clearfix">
                <h2 class="pull-left">Fichas de los usuarios</h2>
            </div>
            <!--BUSCADOR-->
            <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
                <div id="users" class="search-box">
                    <input id="buscar" name="usuario" type="text" class="search-txt" placeholder="Buscar usuario">
                    <a class="search-btn">
                        <i class="fas fa-search"></i>
                    </a>
                </div>
                
                <?php
                echo "<a href='../utilidades/descargar.php?opcion=XML' type='button' class='btn btn-warning btn-lg btn3d' target='_blank'><i class='fas fa-cloud-download-alt'></i> XML</a>";
                echo "<a href='../utilidades/descargar.php?opcion=PDF' type='button' class='btn btn-danger btn-lg btn3d' target='_blank'><i class='fas fa-file-pdf'></i> PDF</a>";
                echo "<a href='javascript:window.print()' type='button' class='btn btn-magick btn-lg btn3d'><i class='fas fa-print'></i> IMPRIMIR</a>";
                echo "<a href='vistas/create.php' class='btn btn-success btn-lg btn3d'><i class='fas fa-user-plus'></i> Añadir usuario</a>";
                ?>
            </form>
        </div>
        <div class="page-header clearfix">
        </div>
        <?php
        error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
        require_once CONTROLLER_PATH . "ControladorUsuario.php";
        require_once CONTROLLER_PATH . "Paginador.php";
        require_once UTILITY_PATH . "funciones.php";

        if (!isset($_POST["usuario"])) {
            $nombre = "";
            $correo = "";
        } else {
            $nombre = filtrado($_POST["usuario"]);
            $correo = filtrado($_POST["usuario"]);
        }

        $controlador = ControladorUsuario::getControlador();

        $pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;

        $consulta = "SELECT * FROM usuarios WHERE nombre LIKE :nombre or correo LIKE :correo";
        $parametros = array(':nombre' => "%".$nombre."%", ':correo' => "%".$correo."%");
        $limite = 100;
        $paginador  = new Paginador($consulta, $parametros, $limite);
        $resultados = $paginador->getDatos($pagina);
        if (count($resultados->datos) > 0) {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>ID</th>";
            echo "<th scope='col'>NOMBRE</th>";
            echo "<th scope='col'>APELLIDOS</th>";
            echo "<th scope='col'>CORREO</th>";
            echo "<th scope='col'>CONTRASEÑA</th>";
            echo "<th scope='col'>TIPO</th>";
            echo "<th scope='col'>TELEFONO</th>";
            echo "<th scope='col'>IMAGEN</th>";
            echo "<th scope='col'>FECHA</th>";
            echo "<th id='no_imprimir' scope='col'>ACCIÓN</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($resultados->datos as $a) {

                $usuario = new Usuario($a->id, $a->nombre, $a->apellidos, $a->correo, $a->password, $a->tipo, $a->telefono, $a->imagen, $a->fecha);

                echo "<tr>";
                echo "<td>" . base64_encode($usuario->getId()) . "</td>";
                echo "<td>" . $usuario->getNombre() . "</td>";
                echo "<td>" . $usuario->getApellidos() . "</td>";
                echo "<td>" . $usuario->getCorreo() . "</td>";
                echo "<td>" . substr($usuario->getPassword() . '... encripted sha' .  256, 50) . "</td>";
                if ($usuario->getTipo() == 'ADMIN'){
                echo "<td scope='row'><span class='badge badge-dot mr-4'><i class='bg-warning'></i>" . $usuario->getTipo() . "</span></td>";
                }else{
                echo "<td scope='row'><span class='badge badge-dot'><i class='bg-info'></i>" . $usuario->getTipo() . "</span></td>";
                }
                echo "<td>" . $usuario->getTelefono() . "</td>";
                echo "<td><img src='/tienda/admin/usuarios/imagenes/" . $usuario->getImagen() . "' width='80px' height='70px'></td>";
                echo "<td>" . $usuario->getFecha() . "</td>";
                echo "<td id='no_imprimir'>";
                echo "<a href='vistas/read.php?id=" . encode($usuario->getId()) . "' title='Ver usuario' data-toggle='tooltip'><i class='fas fa-eye'></i></a>&nbsp;&nbsp;";
                echo "<a href='vistas/update.php?id=" . encode($usuario->getId()) . "' title='Actualizar usuario' data-toggle='tooltip'><i class='fas fa-edit'></i></a>&nbsp;&nbsp;";
                echo "<a href='vistas/delete.php?id=" . encode($usuario->getId()) . "' title='Borrar usuario' data-toggle='tooltip'><i class='fas fa-trash-alt'></i></a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<ul class='pager' id='no_imprimir'>";
            //echo $paginador->crearLinks($enlaces);
            echo "</ul>";
        } else {

            echo "<p class='lead'><em>No se ha encontrado datos de usuarios.</em></p>";
        }
        ?>

    </div>
</div>
<div id="no_imprimir">
    <?php
    /*if (isset($_COOKIE['CONTADOR'])) {
        echo $contador;
        echo $acceso;
    } else
        echo "Es tu primera visita hoy";
    */ ?>
</div>
<br><br><br><br><br><br><br><br>