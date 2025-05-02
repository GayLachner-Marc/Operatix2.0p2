<?php
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
                password_hash($data['password'], PASSWORD_DEFAULT)
            ]);

            $_SESSION['mensaje'] = "Hotel registrado con éxito.";
            header('Location: /admin/hoteles');
            exit();
        } catch (PDOException $e) {
            echo "Error al registrar el hotel: " . $e->getMessage();
        }
    }

    public function actualizarHotel($data)
    {
        if (!isset($data['id_hotel'], $data['id_zona'], $data['comision'], $data['usuario'])) {
            echo "Faltan datos para actualizar el hotel.";
            return;
        }

        try {
            $password = !empty($data['password'])
                ? password_hash($data['password'], PASSWORD_DEFAULT)
                : $this->verHotel($data['id_hotel'])['password'];

            $stmt = $this->pdo->prepare("UPDATE tranfer_hotel SET id_zona = ?, Comision = ?, usuario = ?, password = ? WHERE id_hotel = ?");
            $stmt->execute([
                $data['id_zona'],
                $data['comision'],
                $data['usuario'],
                $password,
                $data['id_hotel']
            ]);

            $_SESSION['mensaje'] = "Hotel actualizado con éxito.";
            header('Location: /admin/hoteles');
            exit();
        } catch (PDOException $e) {
            echo "Error al actualizar el hotel: " . $e->getMessage();
        }
    }

    public function obtenerZonas()
    {
        try {
            $stmt = $this->pdo->query("SELECT id_zona, nombre_zona FROM transfer_zona");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener las zonas: " . $e->getMessage();
            return [];
        }
    }

    public function obtenerUltimosHoteles($limite = 5)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT h.id_hotel, h.Comision, h.usuario, z.nombre_zona 
                FROM tranfer_hotel h
                JOIN transfer_zona z ON h.id_zona = z.id_zona
                ORDER BY h.id_hotel DESC
                LIMIT ?
            ");
            $stmt->bindValue(1, $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener hoteles: " . $e->getMessage();
            return [];
        }
    }

    public function contarTotalHoteles()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM tranfer_hotel");
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

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

    public function verPanelHotel()
{
    if (!isset($_SESSION['usuario'])) {
        echo "No estás logueado.";
        return;
    }

    $hotel = $_SESSION['usuario'];
    $idHotel = $hotel['id_hotel'];
    $comision = $hotel['Comision'] ?? 10;

    try {
        $stmt = $this->pdo->prepare("
            SELECT fecha_reserva, precio 
            FROM transfer_reservas 
            WHERE id_hotel = :id OR id_destino = :id
        ");
        $stmt->execute(['id' => $idHotel]);
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $comisionesPorMes = [];
        foreach ($reservas as $reserva) {
            $mes = date('Y-m', strtotime($reserva['fecha_reserva']));
            $importe = $reserva['precio'] * ($comision / 100);
            if (!isset($comisionesPorMes[$mes])) {
                $comisionesPorMes[$mes] = 0;
            }
            $comisionesPorMes[$mes] += $importe;
        }
        

        require_once BASE_PATH . "/app/mvc/views/Reservas/home_hotel.php";


    } catch (PDOException $e) {
        echo "Error al obtener reservas: " . $e->getMessage();
    }
}


public function loginHotel($data)
{
    if (!isset($data['usuario'], $data['password'])) {
        echo "Faltan usuario o contraseña.";
        return;
    }

    try {
        $stmt = $this->pdo->prepare("SELECT * FROM tranfer_hotel WHERE usuario = ?");
        $stmt->execute([$data['usuario']]);
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($hotel && password_verify($data['password'], $hotel['password'])) {
            $_SESSION['tipo_cliente'] = 'hotel';
            $_SESSION['cliente_id'] = $hotel['id_hotel']; // ✅ Añade esto
            $_SESSION['usuario'] = [
                'id_hotel' => $hotel['id_hotel'],
                'Comision' => $hotel['Comision'],
                'usuario' => $hotel['usuario']
            ];
            header('Location: /hotel/home');
            exit();
        } else {
            echo "Credenciales incorrectas.";
        }
    } catch (PDOException $e) {
        echo "Error en el login del hotel: " . $e->getMessage();
    }
}

}
