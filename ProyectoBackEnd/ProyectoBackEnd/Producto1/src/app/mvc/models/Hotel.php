<?php
// Clase Hotel: representa un hotel de la base de datos
namespace app\mvc\models;

class Hotel
{

    // Atributos privados (solo accesibles desde dentro de la clase)
    private $id_hotel;
    private $id_zona;
    private $comision;
    private $usuario;
    private $password;

    // Constructor: se ejecuta automáticamente al crear un nuevo objeto Hotel
    public function __construct($id_hotel, $id_zona, $comision, $usuario, $password)
    {
        $this->id_hotel = $id_hotel;
        $this->id_zona = $id_zona;
        $this->comision = $comision;
        $this->usuario = $usuario;
        $this->password = $password;
    }

    // Métodos get: devuelven el valor de cada atributo (lectura)
    public function getIdHotel()
    {
        return $this->id_hotel;
    }

    public function getIdZona()
    {
        return $this->id_zona;
    }

    public function getComision()
    {
        return $this->comision;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getPassword()
    {
        return $this->password;
    }

    // Métodos set: permiten modificar los valores de los atributos
    public function setIdZona($id_zona)
    {
        $this->id_zona = $id_zona;
    }

    public function setComision($comision)
    {
        $this->comision = $comision;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}

?>
