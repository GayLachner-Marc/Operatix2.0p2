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
                $reservas[] = $fila; // puedes devolver el array directamente
            }

            return $reservas;

        } catch (PDOException $e) {
            echo "Error al obtener las reservas: " . $e->getMessage();
            return []; // devuelve array vacío en caso de error
        }
    }


    public function crearReserva($data)
    {
        try {
            // Verificar que los campos obligatorios no estén vacíos
            $camposObligatorios = ['id_hotel', 'id_tipo_reserva', 'email_cliente', 'fecha_entrada', 'hora_entrada', 'num_viajeros', 'numero_vuelo_entrada'];
            foreach ($camposObligatorios as $campo) {
                if (empty($data[$campo])) {
                    echo "Faltan datos necesarios: $campo";
                    return;
                }
            }

            // Validación de la fecha de entrada
            if (!strtotime($data['fecha_entrada'])) {
                echo "Fecha de entrada no válida.";
                return;
            }

            // Validar número de viajeros
            if (!is_numeric($data['num_viajeros']) || $data['num_viajeros'] < 1) {
                echo "Número de viajeros no válido.";
                return;
            }

            // Formatear hora de entrada como TIME
            $horaEntrada = null;
            if (!empty($data['hora_entrada']) && preg_match('/^\d{2}:\d{2}$/', $data['hora_entrada'])) {
                $horaEntrada = $data['hora_entrada'] . ':00';
            }

            // Combinar fecha y hora de vuelo salida como DATETIME
            $fechaHoraVueloSalida = null;
            if (!empty($data['fecha_vuelo_salida']) && !empty($data['hora_vuelo_salida'])) {
                if (preg_match('/^\d{2}:\d{2}$/', $data['hora_vuelo_salida'])) {
                    $fechaHoraVueloSalida = $data['fecha_vuelo_salida'] . ' ' . $data['hora_vuelo_salida'] . ':00';
                } else {
                    echo "Hora del vuelo no válida. Usa formato HH:MM.";
                    return;
                }
            }

            // Generar localizador único
            $localizador = strtoupper(bin2hex(random_bytes(4)));

            // Determinar destino: usar el destino si viene, o el hotel como fallback
            $idDestino = isset($data['id_destino']) ? (int)$data['id_destino'] : (int)$data['id_hotel'];

            // Vehículo opcional
            $idVehiculo = isset($data['id_vehiculo']) ? (int)$data['id_vehiculo'] : null;

            // Consulta de inserción
            $stmt = $this->pdo->prepare("INSERT INTO transfer_reservas (
                localizador, id_hotel, id_tipo_reserva, email_cliente,
                fecha_reserva, fecha_modificacion, id_destino, fecha_entrada, hora_entrada,
                numero_vuelo_entrada, origen_vuelo_entrada, hora_vuelo_salida, fecha_vuelo_salida,
                num_viajeros, id_vehiculo
            ) VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Ejecutar la consulta
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

            // Redirigir a lista de reservas
            header("Location: /reserva/listar");
            exit();

        } catch (PDOException $e) {
            echo "❌ Error al crear la reserva: " . $e->getMessage();
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
                    $fila['id_reserva'],
                    $fila['localizador'],
                    $fila['id_hotel'],
                    $fila['id_tipo_reserva'],
                    $fila['email_cliente'],
                    $fila['fecha_reserva'],
                    $fila['fecha_modificacion'],
                    $fila['id_destino'],
                    $fila['fecha_entrada'],
                    $fila['hora_entrada'],
                    $fila['numero_vuelo_entrada'],
                    $fila['origen_vuelo_entrada'],
                    $fila['hora_vuelo_salida'],
                    $fila['fecha_vuelo_salida'],
                    $fila['num_viajeros'],
                    $fila['id_vehiculo']
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
                    $fila['id_reserva'],
                    $fila['localizador'],
                    $fila['id_hotel'],
                    $fila['id_tipo_reserva'],
                    $fila['email_cliente'],
                    $fila['fecha_reserva'],
                    $fila['fecha_modificacion'],
                    $fila['id_destino'],
                    $fila['fecha_entrada'],
                    $fila['hora_entrada'],
                    $fila['numero_vuelo_entrada'],
                    $fila['origen_vuelo_entrada'],
                    $fila['hora_vuelo_salida'],
                    $fila['fecha_vuelo_salida'],
                    $fila['num_viajeros'],
                    $fila['id_vehiculo']
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