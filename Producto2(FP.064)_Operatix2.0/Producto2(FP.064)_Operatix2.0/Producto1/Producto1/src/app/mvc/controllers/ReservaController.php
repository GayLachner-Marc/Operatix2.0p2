<?php
// Incluir el modelo de Reserva para interactuar con la base de datos
namespace app\mvc\controllers;

use app\mvc\models\Reserva;
use PDO;
use PDOException;

require_once __DIR__ . '/../models/Reserva.php';

class ReservaController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarReservas()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM transfer_reservas");
            $reservas = [];
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $reservas[] = $fila;
            }
            return $reservas;
        } catch (PDOException $e) {
            echo "Error al obtener las reservas: " . $e->getMessage();
            return [];
        }
    }

    public function crearReserva($data)
    {
        try {
            $camposObligatorios = ['id_hotel', 'id_tipo_reserva', 'email_cliente', 'fecha_entrada', 'hora_entrada', 'num_viajeros', 'numero_vuelo_entrada'];
            foreach ($camposObligatorios as $campo) {
                if (empty($data[$campo])) {
                    echo "Faltan datos necesarios: $campo";
                    return;
                }
            }

            if (!strtotime($data['fecha_entrada'])) {
                echo "Fecha de entrada no válida.";
                return;
            }

            if (!is_numeric($data['num_viajeros']) || $data['num_viajeros'] < 1) {
                echo "Número de viajeros no válido.";
                return;
            }

            $horaEntrada = null;
            if (!empty($data['hora_entrada']) && preg_match('/^\d{2}:\d{2}$/', $data['hora_entrada'])) {
                $horaEntrada = $data['hora_entrada'] . ':00';
            }

            $fechaHoraVueloSalida = null;
            if (!empty($data['fecha_vuelo_salida']) && !empty($data['hora_vuelo_salida'])) {
                if (preg_match('/^\d{2}:\d{2}$/', $data['hora_vuelo_salida'])) {
                    $fechaHoraVueloSalida = $data['fecha_vuelo_salida'] . ' ' . $data['hora_vuelo_salida'] . ':00';
                } else {
                    echo "Hora del vuelo no válida. Usa formato HH:MM.";
                    return;
                }
            }

            $localizador = strtoupper(bin2hex(random_bytes(4)));
            $idDestino = isset($data['id_destino']) ? (int)$data['id_destino'] : (int)$data['id_hotel'];
            $idVehiculo = isset($data['id_vehiculo']) ? (int)$data['id_vehiculo'] : null;

            $stmt = $this->pdo->prepare("INSERT INTO transfer_reservas (
                localizador, id_hotel, id_tipo_reserva, email_cliente,
                fecha_reserva, fecha_modificacion, id_destino, fecha_entrada, hora_entrada,
                numero_vuelo_entrada, origen_vuelo_entrada, hora_vuelo_salida, fecha_vuelo_salida,
                num_viajeros, id_vehiculo
            ) VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $localizador,
                (int)$data['id_hotel'],
                (int)$data['id_tipo_reserva'],
                $data['email_cliente'],
                $idDestino,
                $data['fecha_entrada'],
                $horaEntrada,
                $data['numero_vuelo_entrada'],
                $data['origen_vuelo_entrada'] ?? null,
                $fechaHoraVueloSalida,
                $data['fecha_vuelo_salida'] ?? null,
                (int)$data['num_viajeros'],
                $idVehiculo
            ]);

            header("Location: /reserva/listar");
            exit();
        } catch (PDOException $e) {
            echo "❌ Error al crear la reserva: " . $e->getMessage();
        }
    }

    public function obtenerUltimasReservas($limite = 5)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT r.id_reserva, r.email_cliente, r.origen_vuelo_entrada, r.id_destino, r.fecha_reserva, z.nombre_zona 
                FROM transfer_reservas r
                JOIN transfer_zona z ON r.id_destino = z.id_zona
                ORDER BY r.id_reserva DESC
                LIMIT ?
            ");
            $stmt->bindValue(1, $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener reservas: " . $e->getMessage();
            return [];
        }
    }

    public function obtenerReservasPorDia($dias = 7)
    {
        try {
            $sql = "SELECT DATE(fecha_reserva) as fecha, COUNT(*) as total
                    FROM transfer_reservas
                    WHERE fecha_reserva >= DATE_SUB(CURDATE(), INTERVAL :dias DAY)
                    GROUP BY DATE(fecha_reserva)
                    ORDER BY fecha DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':dias', $dias, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function contarTotalReservas()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM transfer_reservas");
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function obtenerZonaMasReservada()
    {
        try {
            $sql = "SELECT z.nombre_zona, COUNT(*) as total
                    FROM transfer_reservas r
                    JOIN transfer_zona z ON r.id_destino = z.id_zona
                    GROUP BY z.nombre_zona
                    ORDER BY total DESC
                    LIMIT 1";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['nombre_zona' => 'N/D', 'total' => 0];
        }
    }

    public function verReserva($id_reserva)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_reservas WHERE id_reserva = ?");
            $stmt->execute([$id_reserva]);
            $fila = $stmt->fetch();
            if ($fila) {
                $reserva = new Reserva(
                    $fila['id_reserva'], $fila['localizador'], $fila['id_hotel'], $fila['id_tipo_reserva'],
                    $fila['email_cliente'], $fila['fecha_reserva'], $fila['fecha_modificacion'],
                    $fila['id_destino'], $fila['fecha_entrada'], $fila['hora_entrada'], $fila['numero_vuelo_entrada'],
                    $fila['origen_vuelo_entrada'], $fila['hora_vuelo_salida'], $fila['fecha_vuelo_salida'],
                    $fila['num_viajeros'], $fila['id_vehiculo']
                );
                echo "Detalles de la reserva: <br>";
                echo "Localizador: " . $reserva->getLocalizador() . "<br>";
            } else {
                echo "Reserva no encontrada.";
            }
        } catch (PDOException $e) {
            echo "Error al obtener la reserva: " . $e->getMessage();
        }
    }

    public function modificarReserva($data)
    {
        try {
            if (!isset($data['id_reserva'], $data['fecha_entrada'], $data['hora_entrada'], $data['num_viajeros'])) {
                echo "Faltan datos para modificar la reserva.";
                return;
            }
            $stmt = $this->pdo->prepare("UPDATE transfer_reservas SET
                fecha_entrada = ?,
                hora_entrada = ?,
                num_viajeros = ?
                WHERE id_reserva = ?");
            $stmt->execute([
                $data['fecha_entrada'],
                $data['hora_entrada'],
                $data['num_viajeros'],
                $data['id_reserva']
            ]);
            echo "Reserva modificada con éxito.";
        } catch (PDOException $e) {
            echo "Error al modificar la reserva: " . $e->getMessage();
        }
    }

    public function eliminarReserva($id_reserva)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT fecha_entrada FROM transfer_reservas WHERE id_reserva = ?");
            $stmt->execute([$id_reserva]);
            $reserva = $stmt->fetch();
            if ($reserva) {
                $fecha_entrada = new \DateTime($reserva['fecha_entrada']);
                $hoy = new \DateTime();
                if ($hoy->diff($fecha_entrada)->days <= 2) {
                    echo "No se puede cancelar la reserva, ya que está dentro de las 48 horas.";
                    return;
                }
                $stmt = $this->pdo->prepare("DELETE FROM transfer_reservas WHERE id_reserva = ?");
                $stmt->execute([$id_reserva]);
                echo "Reserva eliminada con éxito.";
            } else {
                echo "Reserva no encontrada.";
            }
        } catch (PDOException $e) {
            echo "Error al eliminar la reserva: " . $e->getMessage();
        }
    }

    public function obtenerReservasPorFecha($fecha_inicio, $fecha_fin)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_reservas WHERE fecha_entrada BETWEEN ? AND ?");
            $stmt->execute([$fecha_inicio, $fecha_fin]);
            $reservas = [];
            while ($fila = $stmt->fetch()) {
                $reserva = new Reserva(
                    $fila['id_reserva'], $fila['localizador'], $fila['id_hotel'], $fila['id_tipo_reserva'],
                    $fila['email_cliente'], $fila['fecha_reserva'], $fila['fecha_modificacion'],
                    $fila['id_destino'], $fila['fecha_entrada'], $fila['hora_entrada'], $fila['numero_vuelo_entrada'],
                    $fila['origen_vuelo_entrada'], $fila['hora_vuelo_salida'], $fila['fecha_vuelo_salida'],
                    $fila['num_viajeros'], $fila['id_vehiculo']
                );
                $reservas[] = $reserva;
            }
            return $reservas;
        } catch (PDOException $e) {
            echo "Error al obtener las reservas: " . $e->getMessage();
        }
    }
}
?>