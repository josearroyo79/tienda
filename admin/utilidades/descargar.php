<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/admin/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescarga.php";
$opcion = $_GET["opcion"];
$id = $_GET["id"];
$fichero = ControladorDescarga::getControlador();
switch ($opcion) {
    case 'XML':
        $fichero->descargarXML();
        break;
    case 'XMLProd':
        $fichero->descargarXMLProd();
        break;
    case 'PDF':
        $fichero->descargarPDF();
        break;
    case 'PDFProd':
        $fichero->descargarPDFProd();
        break;
    case 'PDFUsuario':
        $fichero->descargarPDFUsuario($id);
        break;
    /*case 'FACTURA';
        $id = decode($_GET["id"]);
        $fichero->descargarfactura($id);
        break;*/
}
