<?php

namespace app\mvc\models;

use PDO;
use PDOException;

class ClienteRepository
{
    private $db;

    public function __construct()
    {
        // Configura estos valores según tu entorno
        $host = 'db'; // o 'localhost' si no estás usando Docker
        $dbname = 'isla_transfers';
        $username = 'root';
        $password = 'root';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM transfer_viajeros WHERE id_viajero = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $email, $password = null)
    {
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE transfer_viajeros SET nombre = ?, email = ?, password = ? WHERE id_viajero = ?");
            return $stmt->execute([$nombre, $email, $hash, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE transfer_viajeros SET nombre = ?, email = ? WHERE id_viajero = ?");
            return $stmt->execute([$nombre, $email, $id]);
        }
    }
}
