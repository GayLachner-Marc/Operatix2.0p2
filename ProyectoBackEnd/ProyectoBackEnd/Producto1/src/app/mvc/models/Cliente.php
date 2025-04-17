<?php
namespace app\mvc\models;

class Cliente
{
    private $id_viajero;
    private $nombre;
    private $email;
    private $password;

    public function __construct($id_viajero, $nombre, $email, $password)
    {
        $this->id_viajero = $id_viajero;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId() { return $this->id_viajero; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
}
?>
