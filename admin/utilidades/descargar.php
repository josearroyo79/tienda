<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescargaUser.php";
require_once CONTROLLER_PATH . "ControladorDescarga.php";
$opcion = $_GET["opcion"];
$id = $_GET["id"];
$fichero = ControladorDescargaUser::getControlador();
switch ($opcion) {
    case 'XML':
        $fichero->descargarXML();
        break;
    case 'PDF':
        $fichero->descargarPDF();
        break;
    case 'PDFUsuario':
        $fichero->descargarPDFUsuario($id);
        break;
}
$fichero = ControladorDescarga::getControlador();
switch ($opcion) {
    case 'XML':
        $fichero->descargarXML();
        break;
    case 'PDF':
        $fichero->descargarPDF();
        break;
    case 'PDFUsuario':
        $fichero->descargarPDFUsuario($id);
        break;
}