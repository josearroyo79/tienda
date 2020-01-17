<style>
div.span1{
    padding:20px;
    margin: 100px;
}
a#boton {
    padding:50px;
}
</style>
<?php


if (!isset($_SESSION['email']['admin']) || ($_SESSION['email']['admin']) != "SI" ){
    //Botones usuario normal
echo "<a href='utilidades/descargar.php?opcion=XML' type='button' class='btn btn-deep-orange' target='_blank'><i class='fas fa-cloud-download-alt'></i> XML</a>";
echo "<a href='utilidades/descargar.php?opcion=JSON' type='button' class='btn btn-deep-purple' target='_blank'><i class='fas fa-cloud-download-alt'></i> JSON</a>";
echo "<a href='utilidades/descargar.php?opcion=TXT' type='button' class='btn btn-outline-default waves-effect' target='_blank'><i class='fas fa-file-download'></i> TXT</a>";
echo "<a href='utilidades/descargar.php?opcion=PDF' type='button' class='btn btn-outline-secondary waves-effect' target='_blank'><i class='fas fa-file-pdf'></i> PDF</a>";
echo "<a href='javascript:window.print()' type='button' class='btn btn-outline-info waves-effect'><i class='fas fa-print'></i> IMPRIMIR</a>";
} else {
        //Botones administrador
echo "<a href='utilidades/descargar.php?opcion=XML' type='button' class='btn btn-deep-orange' target='_blank'><i class='fas fa-cloud-download-alt'></i> XML</a>";
echo "<a href='utilidades/descargar.php?opcion=JSON' type='button' class='btn btn-deep-purple' target='_blank'><i class='fas fa-cloud-download-alt'></i> JSON</a>";
echo "<a href='utilidades/descargar.php?opcion=TXT' type='button' class='btn btn-outline-default waves-effect' target='_blank'><i class='fas fa-file-download'></i> TXT</a>";
echo "<a href='utilidades/descargar.php?opcion=PDF' type='button' class='btn btn-outline-secondary waves-effect' target='_blank'><i class='fas fa-file-pdf'></i> PDF</a>";
echo "<a href='javascript:window.print()' type='button' class='btn btn-outline-info waves-effect'><i class='fas fa-print'></i> IMPRIMIR</a>";
echo "<a href='vistas/create.php' class='btn aqua-gradient'><i class='fas fa-user-plus'></i> Añadir usuario</a>";
}
?>
<h1>ESTE ES EL MENÚ DE ADMINISTRADOR</h1>
<div class="span1">
    <a id="boton" href="producto/index.php" class="btn btn-primary">
        <i class="fab fa-product-hunt"></i>
        <span><strong>ADMINISTRAR PRODUCTOS</strong></span>            
    </a>
</div>
<div class="span1">
    <a id="boton" href="usuarios/index.php" class="btn btn-primary">
        <i class="fas fa-user-cog"></i>
        <span><strong>ADMINISTRAR USUARIOS</strong></span>        	
    </a>
</div>
<div class="span1">
    <a id="boton" href="../catalogo.php" class="btn btn-success">
        <i class="fas fa-shopping-basket"></i>
        <span><strong>ADMINISTRAR CATÁLOGO</strong></span>       
    </a> 	
</div>
<div class="span1">
    <a id="boton" href="#" class="btn btn-danger">
        <i class="fas fa-sign-out-alt"></i>
	    <span><strong>SALIR</strong></span>        	
    </a>
</div>
<br><br><br>