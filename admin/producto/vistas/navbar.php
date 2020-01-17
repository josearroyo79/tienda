<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-nav">
      <?php
      // Abrimos las sesiones para leerla
     session_start();
      if(isset($_SESSION['USUARIO']['email'])){
       // echo '<li><a href="/php/tienda/index.php"><a href="#" class="btn btn-lg btn-default">Inicio <span class="glyphicon glyphicon-home"></span></a></a></li>';
        // Menu de administrador
        //require_once VIEW_PATH."listado.php";
    } else{
        // Menú normal
        //require_once VIEW_PATH."index.php";
        echo '<li><a href="/tienda/login.php" class="btn btn-xs btn-default">Inicio <span class="glyphicon glyphicon-home"></span></a></li>';
  }
  ?>
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><p class="navbar-text">2ºIAW-ASIR</p></li>
        <?php
          if(!isset($_SESSION['USUARIO']['email'])){
            echo '<li><a href="#" class="btn btn-xs btn-default">Registrarse <span class="glyphicon glyphicon-user"></span></a></li>';
            echo '<li><a href="/tienda/login.php" class="btn btn-xs btn-default">Inicio de Sesión <span class="glyphicon glyphicon-user"></span> </a></li>';
          }else{
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['USUARIO']['email'].'</a></li>';
            echo '<li><a href="/tienda/login.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
          }
        ?>
    </ul>
  </div>
</nav>
<br><hr>