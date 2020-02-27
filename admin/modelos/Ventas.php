<?php
class Ventas {
    private $idVenta;
    private $fecha;
    private $total;
    private $nombre;
    private $correo;
    private $direccion;
    private $nombreTarjeta;
    private $numTarjeta;

    function __construct($idVenta, $fecha, $total, $nombre, $correo, $direccion, $nombreTarjeta, $numTarjeta) {
        $this->idventa = $idventa;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->nombreTarjeta = $nombreTarjeta;
        $this->numTarjeta = $numTarjeta;
    }
    function getIdVenta() {
        return $this->idVenta;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getTotal() {
        return $this->total;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getNombreTarjeta() {
        return $this->nombreTarjeta;
    }

    function getNumTarjeta() {
        return $this->numTarjeta;
    }

    function setId($idVenta) {
        $this->idVenta = $idVenta;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setNombreTarjeta($nombreTarjeta) {
        $this->nombreTarjeta = $nombreTarjeta;
    }

    function setNumTarjeta($numTarjeta) {
        $this->numTarjeta = $numTarjeta;
    }
}
?>