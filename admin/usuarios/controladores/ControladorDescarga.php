<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/usuarios/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once MODEL_PATH . "Usuario.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;

class ControladorDescarga
{
    private $fichero;
    
    static private $instancia = null;

    private function __construct()
    {
        //echo "Conector creado";
    }
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }
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
            $usuario->appendChild($doc->createElement('email', $a->getEmail()));
            $usuario->appendChild($doc->createElement('admin', $a->getAdmin()));
            $usuario->appendChild($doc->createElement('telefono', $a->getTelefono()));
            $usuario->appendChild($doc->createElement('imagen', $a->getImagen()));
            $usuario->appendChild($doc->createElement('fecha', $a->getFecha()));

            //Insertamos
            $usuarios->appendChild($usuario);
        }

        $doc->appendChild($usuarios);
        header('Content-type: application/xml');
        echo $doc->saveXML();

        exit;
    }

    public function descargarPDF(){
        $slu ='<h2 class="pull-left">Fichas de los usuarios:</h2>';
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $slu.="<table class='table table-bordered table-striped'>";
            $slu.="<thead>";
            $slu.="<tr>";
            $slu.="<th>Nombre</th>";
            $slu.="<th>Apellidos</th>";
            $slu.="<th>Email</th>";
            $slu.="<th>Admin</th>";
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
                $slu.="<td>" . $usuario->getEmail() . "</td>";
                $slu.="<td>" . $usuario->getAdmin() . "</td>";
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
            $slu.="<th>Email</th>";
            $slu.="<th>Admin</th>";
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
                $slu.="<td>" . $usuario->getEmail() . "</td>";
                $slu.="<td>" . $usuario->getAdmin() . "</td>";
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
}
