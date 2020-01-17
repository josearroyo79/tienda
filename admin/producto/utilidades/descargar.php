<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/producto/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescarga.php";
$opcion = $_GET["opcion"];
$fichero = ControladorDescarga::getControlador();
switch ($opcion) {
    case 'TXT':
        $fichero->descargarTXT();
        break;
    case 'PDF':
        $fichero->descargarPDF();
        break;
}
