 <!-- AQUÍ EMPIEZA EL NAVBAR-->
 <ul class="nav justify-content-center grey lighten-4 py-4">
   <img src="/tienda/admin/usuarios/img/RR.png" alt="RR" width="40px" id="rr">
   <li class="nav-item">
     <a class="nav-link active" href=<?php echo "/tienda/admin/usuarios/index.php"; ?>><i class="fas fa-home"></i>Inicio</a>
   </li>
   <!--Para todos-->
   <li class="nav-item">
     <a class="nav-link" href="/tienda/admin/usuarios/vistas/informacion.php">Información</a>
   </li>

   <?php
    if (!isset($_SESSION['USUARIO']['correo'])) {
      echo '<li class="nav-item">';
      echo '<a class="nav-link2" href="/tienda/login.php"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>';
      echo '</li>';
    } else {
      echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> ' . $_SESSION['USUARIO']['correo'] . '</a></li>';
      echo '<li><a href="/tienda/login.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
    }
    ?>
 </ul>
 <br><br>