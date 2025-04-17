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

                echo "Reserva Localizador: " . $reserva->getLocalizador() . "<br>";
            }
        } catch (PDOException $e) {
            echo "Error al obtener las reservas: " . $e->getMessage();
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
    
            // Validar y formatear hora de vuelo salida
            $horaVueloSalida = null;
            if (!empty($data['hora_vuelo_salida'])) {
                if (!preg_match('/^\d{2}:\d{2}$/', $data['hora_vuelo_salida'])) {
                    echo "Hora del vuelo no válida. Usa formato HH:MM.";
                    return;
                }
                $horaVueloSalida = $data['hora_vuelo_salida'] . ':00';
            }
    
            // Validar y formatear hora de entrada
            $horaEntrada = null;
            if (!empty($data['hora_entrada'])) {
                if (!preg_match('/^\d{2}:\d{2}$/', $data['hora_entrada'])) {
                    echo "Hora de entrada no válida. Usa formato HH:MM.";
                    return;
                }
                $horaEntrada = $data['hora_entrada'] . ':00';
            }
    
            // Generar localizador único
            $localizador = strtoupper(bin2hex(random_bytes(4)));
    
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
                $data['id_hotel'],
                $data['id_tipo_reserva'],
                $data['email_cliente'],
                $data['id_destino'] ?? $data['id_hotel'],
                $data['fecha_entrada'],
                $horaEntrada,
                $data['numero_vuelo_entrada'],
                $data['origen_vuelo_entrada'] ?? null,
                $horaVueloSalida,
                $data['fecha_vuelo_salida'] ?? null,
                $data['num_viajeros'],
                $data['id_vehiculo'] ?? null
            ]);
    
            echo "Reserva creada con éxito.";
    
        } catch (PDOException $e) {
            echo "Error al crear la reserva: " . $e->getMessage();
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