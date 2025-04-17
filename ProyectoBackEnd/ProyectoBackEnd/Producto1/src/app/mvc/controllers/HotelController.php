<?php
// Incluir el modelo de Hotel para interactuar con la base de datos
namespace app\mvc\controllers;

use PDO;
use PDOException;
use app\mvc\models\Hotel;

require_once __DIR__ . '/../models/Hotel.php';

class HotelController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Listar todos los hoteles
    public function listarHoteles()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM tranfer_hotel");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los hoteles: " . $e->getMessage();
            return [];
        }
    }

    // Ver detalles de un hotel específico
    public function verHotel($id_hotel)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tranfer_hotel WHERE id_hotel = ?");
            $stmt->execute([$id_hotel]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los detalles del hotel: " . $e->getMessage();
            return null;
        }
    }

    // Registrar un nuevo hotel
    public function registrarHotel($data)
    {
        if (!isset($data['id_zona'], $data['comision'], $data['usuario'], $data['password'])) {
            echo "Faltan datos necesarios.";
            return;
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO tranfer_hotel (id_zona, Comision, usuario, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $data['id_zona'],
                $data['comision'],
                $data['usuario'],
                $data['password']
            ]);

            $_SESSION['mensaje'] = "Hotel registrado con éxito.";
            header('Location: /admin/hoteles');
            exit();
        } catch (PDOException $e) {
            echo "Error al registrar el hotel: " . $e->getMessage();
        }
    }

    // Actualizar un hotel existente
    public function actualizarHotel($data)
    {
        if (!isset($data['id_hotel'], $data['id_zona'], $data['comision'], $data['usuario'], $data['password'])) {
            echo "Faltan datos para actualizar el hotel.";
            return;
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE tranfer_hotel SET id_zona = ?, Comision = ?, usuario = ?, password = ? WHERE id_hotel = ?");
            $stmt->execute([
                $data['id_zona'],
                $data['comision'],
                $data['usuario'],
                $data['password'],
                $data['id_hotel']
            ]);

            $_SESSION['mensaje'] = "Hotel actualizado con éxito.";
            header('Location: /admin/hoteles');
            exit();
        } catch (PDOException $e) {
            echo "Error al actualizar el hotel: " . $e->getMessage();
        }
    }

    // Eliminar un hotel
    public function eliminarHotel($id_hotel)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM tranfer_hotel WHERE id_hotel = ?");
            $stmt->execute([$id_hotel]);
            $_SESSION['mensaje'] = "Hotel eliminado correctamente.";
            header('Location: /admin/hoteles');
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el hotel: " . $e->getMessage();
        }
    }
}
