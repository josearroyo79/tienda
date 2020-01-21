<?php

/**
 * Description of Usuario
 *
 * @author link
 */
class Usuario {
    //put your code here
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $pass;
    private $admin;
    private $telefono;
    private $imagen;
    private $fecha;
    
    // Constructor
    public function __construct($id, $nombre, $apellidos, $email, $password, $admin, $telefono, $imagen, $fecha) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->telefono = $telefono;
        $this->imagen = $imagen;
        $this->fecha = $fecha;
    }
    
    // **** GETS & SETS
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    
    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }
    function getPassword() {
        return $this->password;
    }
    function getAdmin() {
        return $this->admin;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getImagen() {
        return $this->imagen;
    }
    
    function getFecha() {
        return $this->fecha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }
    
    function setEmail($email) {
        $this->email = $email;
    }
    
    function setPassword($password) {
        $this->password = $password;
    }

    function setAdmin($admin) {
        $this->admin= $admin;
    } 

    function setTelefono($telefono) {
        $this->telefono= $telefono;
    } 

    function setImagen($imagen) {
        $this->imagen= $imagen;
    } 

    function setFecha($fecha) {
        $this->fecha= $fecha;
    }
}

