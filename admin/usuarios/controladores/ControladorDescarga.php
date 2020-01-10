<?php

// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorLuchador.php";
require_once MODEL_PATH . "Luchador.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;


/**
 * Controlador de descargas
 */
class ControladorDescarga
{

    // Configuración del servidor
    private $fichero;

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }
    public function descargarXML(){
        $this->fichero = "luchadores.xml";
        $lista = $controlador = ControladorLuchador::getControlador();
        $lista = $controlador->listarLuchadores("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $luchadores = $doc->createElement('luchadores');

        foreach ($lista as $a) {
            // Creamos el nodo
            $luchador = $doc->createElement('luchador');
            // Añadimos elementos
            $luchador->appendChild($doc->createElement('nombre', $a->getNombre()));
            $luchador->appendChild($doc->createElement('raza', $a->getRaza()));
            $luchador->appendChild($doc->createElement('ki', $a->getKi()));
            $luchador->appendChild($doc->createElement('transformacion', $a->getTransformacion()));
            $luchador->appendChild($doc->createElement('ataque', $a->getAtaque()));
            $luchador->appendChild($doc->createElement('planeta', $a->getPlaneta()));
            $luchador->appendChild($doc->createElement('imagen', $a->getImagen()));

            //Insertamos
            $luchadores->appendChild($luchador);
        }

        $doc->appendChild($luchadores);
        header('Content-type: application/xml');
        //header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida
        echo $doc->saveXML();

        exit;
    }

    public function descargarPDF(){
        $slu ='<h2 class="pull-left">Fichas de los luchadores:</h2>';
        $lista = $controlador = ControladorLuchador::getControlador();
        $lista = $controlador->listarLuchadores("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $slu.="<table class='table table-bordered table-striped'>";
            $slu.="<thead>";
            $slu.="<tr>";
            $slu.="<th>Nombre</th>";
            $slu.="<th>Raza</th>";
            //$slu.="<th>Contraseña</th>";
            $slu.="<th>Ki</th>";
            $slu.="<th>Transformacion</th>";
            $slu.="<th>Ataque</th>";
            $slu.="<th>Planeta</th>";
            $slu.="<th>Imagen</th>";
            $slu.="</tr>";
            $slu.="</thead>";
            $slu.="<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $luchador) {
                // Pintamos cada fila
                $slu.="<tr>";
                $slu.="<td>" . $luchador->getNombre() . "</td>";
                $slu.="<td>" . $luchador->getRaza() . "</td>";
                //$slu.="<td>" . str_repeat("*",strlen($luchador->getPassword())) . "</td>";
                $slu.="<td>" . $luchador->getKi() . "</td>";
                $slu.="<td>" . $luchador->getTransformacion() . "</td>";
                $slu.="<td>" . $luchador->getAtaque() . "</td>";
                $slu.="<td>" . $luchador->getPlaneta() . "</td>";
                // Para sacar una imagen hay que decirle el directorio real donde está
                $slu.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/iaw/dragonball/imagenes/".$luchador->getImagen()."'  style='max-width: 20mm; max-height: 20mm'></td>";
                $slu.="</tr>";
            }
            $slu.="</tbody>";
            $slu.="</table>";
        } else {
            // Si no hay nada seleccionado
            $slu.="<p class='lead'><em>No se ha encontrado datos de luchadores</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($slu);
        $pdf->output('luchadores.pdf');

    }

    public function descargarPDFLuchador($id){
        $id = decode($id);
        $slu ='<h2 class="pull-left">Fichas de los luchadores:</h2>';
        $lista = $controlador = ControladorLuchador::getControlador();
        $lista = $controlador->listarLuchador($id);
        if (!is_null($lista) && count($lista) > 0) {
            $slu.="<table class='table table-bordered table-striped'>";
            $slu.="<thead>";
            $slu.="<tr>";
            $slu.="<th>Nombre</th>";
            $slu.="<th>Raza</th>";
            //$slu.="<th>Contraseña</th>";
            $slu.="<th>Ki</th>";
            $slu.="<th>Transformacion</th>";
            $slu.="<th>Ataque</th>";
            $slu.="<th>Planeta</th>";
            $slu.="<th>Imagen</th>";
            $slu.="</tr>";
            $slu.="</thead>";
            $slu.="<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $luchador) {
                // Pintamos cada fila
                $slu.="<tr>";
                $slu.="<td>" . $luchador->getNombre() . "</td>";
                $slu.="<td>" . $luchador->getRaza() . "</td>";
                //$slu.="<td>" . str_repeat("*",strlen($luchador->getPassword())) . "</td>";
                $slu.="<td>" . $luchador->getKi() . "</td>";
                $slu.="<td>" . $luchador->getTransformacion() . "</td>";
                $slu.="<td>" . $luchador->getAtaque() . "</td>";
                $slu.="<td>" . $luchador->getPlaneta() . "</td>";
                // Para sacar una imagen hay que decirle el directorio real donde está
                $slu.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/iaw/dragonball/imagenes/".$luchador->getImagen()."'  style='max-width: 20mm; max-height: 20mm'></td>";
                $slu.="</tr>";
            }
            $slu.="</tbody>";
            $slu.="</table>";
        } else {
            // Si no hay nada seleccionado
            $slu.="<p class='lead'><em>No se ha encontrado datos de luchadores</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($slu);
        $pdf->output('luchadores.pdf');

    }
}
