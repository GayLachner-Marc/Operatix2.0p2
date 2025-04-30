<?php
// Clase Vehiculo: representa un vehículo con sus datos reales desde la base de datos
namespace app\mvc\models;

class Vehiculo
{

    private $id_vehiculo;
    private $description;
    private $email_conductor;
    private $password;

    public function __construct($id_vehiculo, $description, $email_conductor, $password)
    {
        $this->id_vehiculo = $id_vehiculo;
        $this->description = $description;
        $this->email_conductor = $email_conductor;
        $this->password = $password;
    }

    public function getIdVehiculo()
    {
        return $this->id_vehiculo;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getEmailConductor()
    {
        return $this->email_conductor;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setDescription($description)
    {
        $this->descripcion = $descripcion;
    }

    public function setEmailConductor($email_conductor)
    {
        $this->email_conductor = $email_conductor;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}

?>
