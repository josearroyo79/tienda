 <header>
 <style>
        @import '/tienda/estilos/navbar/navbar.css';
    </style>
   <!--======================================Navigation Bar=================================================-->
   <nav class="navbar navbar-expand-lg navStyle">
     <img src="/tienda/admin/imagenes/RR.png" height="60px">
     <button class="navbar-toggler" data-toggle="collapse" data-target="#mainMenu">
       <span><i class="fas fa-align-right iconStyle"></i></span>
     </button>
     <div class="collapse navbar-collapse" id="mainMenu">
       <ul class="navbar-nav ml-auto navList">
         <li class="nav-item active"><a href=<?php echo "/tienda/index.php"; ?> class="nav-link"><i class="fas fa-home"></i>Inicio<span class="sr-only"></span></a></li>

         <?php
          error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));

          require_once CONTROLLER_PATH . "ControladorUsuario.php";
          require_once MODEL_PATH . "Usuario.php";
          require_once CONTROLLER_PATH . "Paginador.php";
          require_once UTILITY_PATH . "funciones.php";

          if (!isset($_POST["correo"])) {
            $nombre = "";
          } else {
            $nombre = filtrado($_POST["correo"]);
          }

          $controlador = ControladorUsuario::getControlador();

          $pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
          $enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;


          //Menu ADMINISTRADOR

          // Consulta
          $consulta = "SELECT * FROM usuarios WHERE correo LIKE :correo";
          $parametros = array(':correo' => "%" . $correo . "%");
          $limite = 100;
          $paginador  = new Paginador($consulta, $parametros, $limite);
          $resultados = $paginador->getDatos($pagina);
          foreach ($resultados->datos as $a) {

            $usuario = new Usuario($a->id, $a->nombre, $a->apellidos, $a->correo, $a->password, $a->tipo, $a->telefono, $a->imagen, $a->fecha);

            $usuario->getId();
            $usuario->getNombre();
            $usuario->getApellidos();
            $usuario->getCorreo();
            base64_encode($usuario->getPassword());
            $usuario->getTipo();
            $usuario->getTelefono();
            $usuario->getImagen();
            $usuario->getFecha();
          }
          // Si la sesión del usuario no tiene el parametro tipo con el valor admin:
          session_start();
          if ($_SESSION['tipo'] != "ADMIN") {
            // Menú normal
          } else {
            // Menu de administrador (en caso de que tenga como parametro de tipo "ADMIN") se le muestra el menú
            echo '<li class="nav-item"><a href="/tienda/admin" class="nav-link"><i class="fas fa-cogs"></i>Administración</a></li>';
          }
          ?>
         <!--Para todos-->
         <?php
          if (!isset($_SESSION['USUARIO']['correo'])) {
            echo '<li class="nav-item"><a href="/tienda/login.php" class="nav-link"><i class="fas fa-briefcase"></i>Iniciar sesión</a></li>';
          } else {
            echo '<li class="nav-item"><a href="/tienda/vistas/carrito.php" class="nav-link">Carrito <i class="fas fa-shopping-cart"></i></a></li>';
            echo '<li class="nav-item"><a href="/tienda/vistas/perfil.php?id=' . encode($_SESSION['id']) . '" class="nav-link"><i class="fas fa-users-cog"></i>' . $_SESSION['USUARIO']['correo'] . '</a></li>';
            // EN ESTE BOTÓN QUE ES EN EL QUE APARECE LOGUEADO EL CORREO, CUANDO SE LE PULSE DEBE COGER EL ID DEL USUARIO DE LA SESIÓN:
            echo '<li class="nav-item"><a href="/tienda/login.php" class="nav-link"><i class="fas fa-sign-out-alt"></i>Salir</a></li>';
          }
          ?>
                </ul>
            </div>
        </nav>              
    </header>

         
       </ul>
       <br><br>