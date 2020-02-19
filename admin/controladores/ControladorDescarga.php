<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once MODEL_PATH . "Usuario.php";
require_once VENDOR_PATH . "autoload.php";

use Spipu\Html2Pdf\HTML2PDF;

class ControladorDescarga
{
    //private $fichero;
    
    static private $instancia = null;

    private function __construct(){}
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }


    //---------------------------------------------------DESCARGAS USUARIOS-----------------------------------------------
    public function descargarXML()
    {
        $this->fichero = "usuarios.xml";
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $usuarios = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            $usuario = $doc->createElement('usuario');
            
            $usuario->appendChild($doc->createElement('nombre', $a->getNombre()));
            $usuario->appendChild($doc->createElement('apellidos', $a->getApellidos()));
            $usuario->appendChild($doc->createElement('correo', $a->getCorreo()));
            $usuario->appendChild($doc->createElement('contraseña', hash("sha256",$a->getPassword())));
            $usuario->appendChild($doc->createElement('tipo', $a->getTipo()));
            $usuario->appendChild($doc->createElement('telefono', $a->getTelefono()));
            $usuario->appendChild($doc->createElement('imagen', $a->getImagen()));
            $usuario->appendChild($doc->createElement('fecha', $a->getFecha()));

            $usuarios->appendChild($usuario);
        }

        $doc->appendChild($usuarios);
        header('Content-type: application/xml');
        echo $doc->saveXML();

        exit;
    }

    public function descargarPDF(){
        
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $slu.="<div class='main-content'>";
            $slu.="<div class='container mt-7'>";
            $slu.="<div class='row mt-5'>";
            $slu.="<div class='col'>";
            $slu.="<div class='card bg-default shadow'>";
            $slu.="<div class='card-header bg-transparent border-0'>";
            $slu.="<h3 class='text-white mb-0'>Fichas de los usuarios</h3>";
            $slu.="</div>";
            $slu.="<div class='table-responsive'>";
            $slu.="<table class='table align-items-center table-dark table-flush'>";
            $slu.="<thead class='thead-dark'>";
            $slu.="<tr>";
            $slu.="<th scope='col'>Nombre</th>";
            $slu.="<th scope='col'>Apellidos</th>";
            $slu.="<th scope='col'>Correo</th>";
            $slu.="<th scope='col'>Contraseña</th>";
            $slu.="<th scope='col'>Tipo</th>";
            $slu.="<th scope='col'>Telefono</th>";
            $slu.="<th scope='col'>Imagen</th>";
            $slu.="<th scope='col'>Fecha de registro</th>";
            $slu.="</tr>";
            $slu.="</thead>";
            $slu.="<tbody>";
            foreach ($lista as $usuario) {
                $slu.="<tr>";
                $slu.="<td scope='row'>" . $usuario->getNombre() . "</td>";
                $slu.="<td scope='row'>" . $usuario->getApellidos() . "</td>";
                $slu.="<td scope='row'>" . $usuario->getCorreo() . "</td>";
                $slu.="<td scope='row'>" . hash("sha256",$usuario->getPassword()) . "</td>";
                if ($usuario->getTipo() == 'ADMIN')
                $slu.="<td scope='row'><span class='badge badge-dot mr-4'><i class='bg-warning'></i>" . $usuario->getTipo() . "</span></td>";
                else
                $slu.="<td scope='row'><span class='badge badge-dot'><i class='bg-info'></i>" . $usuario->getTipo() . "</span></td>";
                $slu.="<td scope='row'>" . $usuario->getTelefono() . "</td>";
                $slu.="<td scope='row'><img src='".$_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/imagenes/".$usuario->getImagen()."'  style='max-width: 20mm; max-height: 20mm'></td>";
                $slu.="<td scope='row'>" . $usuario->getFecha() . "</td>";
                $slu.="</tr>";
            }
            $slu.="</tbody>";
            $slu.="</table>";
            $slu.="</div>";
            $slu.="</div>";
            $slu.="</div>";
            $slu.="</div>";
            $slu.="</div>";
            $slu.="</div>";
        } else {
            $slu.="<p class='lead'><em>No se ha encontrado datos de usuarios</em></p>";
        }
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($slu);
        $pdf->output('usuarios.pdf');

    }

    public function descargarPDFUsuario($id){
        $id = decode($id);
        $slu ='<h2 class="pull-left">Fichas de los usuarios:</h2>';
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuario($id);
        if (!is_null($lista) && count($lista) > 0) {
            $slu.="<table class='table table-bordered table-striped'>";
            $slu.="<thead>";
            $slu.="<tr>";
            $slu.="<th>Nombre</th>";
            $slu.="<th>Apellidos</th>";
            $slu.="<th>Correo</th>";
            $slu.="<th>Contraseña</th>";
            $slu.="<th>Tipo</th>";
            $slu.="<th>Telefono</th>";
            $slu.="<th>Imagen</th>";
            $slu.="<th>Fecha de registro</th>";
            $slu.="</tr>";
            $slu.="</thead>";
            $slu.="<tbody>";
            foreach ($lista as $usuario) {
                $slu.="<tr>";
                $slu.="<td>" . $usuario->getNombre() . "</td>";
                $slu.="<td>" . $usuario->getApellidos() . "</td>";
                $slu.="<td>" . $usuario->getCorreo() . "</td>";
                $slu.="<td>" . hash("sha256",$usuario->getPassword()) . "</td>";
                $slu.="<td>" . $usuario->getTipo() . "</td>";
                $slu.="<td>" . $usuario->getTelefono() . "</td>";
                $slu.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/imagenes/".$usuario->getImagen()."'  style='max-width: 20mm; max-height: 20mm'></td>";
                $slu.="<td>" . $usuario->getFecha() . "</td>";
                $slu.="</tr>";
            }
            $slu.="</tbody>";
            $slu.="</table>";
        } else {
            $slu.="<p class='lead'><em>No se ha encontrado datos de usuarios</em></p>";
        }
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($slu);
        $pdf->output('usuarios.pdf');
    }


    //---------------------------------------------------DESCARGAS PRODUCTOS---------------------------------------------------
    public function descargarXMLProd()
    {
        $this->fichero = "productos.xml";
        $lista = $controlador = ControladorProducto::getControlador();
        $lista = $controlador->listarProductos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $productos = $doc->createElement('productos');

        foreach ($lista as $a) {
            $producto = $doc->createElement('producto');
            
            $producto->appendChild($doc->createElement('nombre', $a->getNombre()));
            $producto->appendChild($doc->createElement('tipo', $a->getTipo()));
            $producto->appendChild($doc->createElement('marca', $a->getMarca()));
            $producto->appendChild($doc->createElement('precio', $a->getPrecio()));
            $producto->appendChild($doc->createElement('unidades', $a->getUnidades()));
            $producto->appendChild($doc->createElement('imagen', $a->getImagen()));

            //Insertamos
            $productos->appendChild($producto);
        }

        $doc->appendChild($productos);
        header('Content-type: application/xml');
        echo $doc->saveXML();

        exit;
    }

    public function descargarPDFProd(){
        $spro ='<h2 class="pull-left">Catálogo</h2>';
        $lista = $controlador = ControladorProducto::getControlador();
        $lista = $controlador->listarProductos("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $spro.="<table class='table table-bordered table-striped'>";
            $spro.="<thead>";
            $spro.="<tr>";
            $spro.="<th>Nombre</th>";
            $spro.="<th>Tipo</th>";
            $spro.="<th>Marca</th>";
            //$sal.="<th>Contraseña</th>";
            $spro.="<th>Precio</th>";
            $spro.="<th>Unidades</th>";
            $spro.="<th>Imagen</th>";
            $spro.="</tr>";
            $spro.="</thead>";
            $spro.="<tbody>";
            
            foreach ($lista as $producto) {
                
                $spro.="<tr>";
                $spro.="<td>" . $producto->getNombre() . "</td>";
                $spro.="<td>" . $producto->getTipo() . "</td>";
                $spro.="<td>" . $producto->getMarca() . "</td>";
                $spro.="<td>" . $producto->getPrecio() . "</td>";
                $spro.="<td>" . $producto->getUnidades() . "</td>";
                // Ruta donde se almacenan la IMG
                $spro.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/producto/imagen_producto/".$producto->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $spro.="</tr>";
            }
            $spro.="</tbody>";
            $spro.="</table>";
        } else {
            $spro.="<p class='lead'><em>No se ha encontrado productos.</em></p>";
        }
        $pdf=new HTML2PDF('R','A5','es','true','UTF-8');
        $pdf->writeHTML($spro);
        $pdf->output('listado.pdf');

    }
}
