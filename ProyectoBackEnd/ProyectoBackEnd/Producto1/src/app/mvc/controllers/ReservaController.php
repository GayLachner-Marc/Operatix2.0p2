<?php
// Incluir el modelo de Reserva para interactuar con la base de datos
namespace app\mvc\controllers;
use Reserva;

require_once __DIR__ . '/../models/Reserva.php';

// Controlador para las operaciones relacionadas con las reservas
class ReservaController
{

    private $pdo;

    // Constructor para inicializar la conexión PDO
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Método para listar todas las reservas
    public function listarReservas()
    {
        try {
            // Ejecutamos una consulta para obtener todas las reservas
            $stmt = $this->pdo->query("SELECT * FROM transfer_reservas");

            // Mostramos las reservas
            while ($fila = $stmt->fetch()) {
                // Creamos un objeto Reserva por cada fila de datos
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

                // Aquí puedes hacer algo con $reserva, como mostrarla en una vista
                echo "Reserva Localizador: " . $reserva->getLocalizador() . "<br>";
                // Y de aquí seguiría mostrando más detalles de la reserva según se necesite
            }

        } catch (PDOException $e) {
            echo "Error al obtener las reservas: " . $e->getMessage();
        }
    }

    // Método para crear una nueva reserva
    public function crearReserva($data)
    {
        try {
            // Validamos los datos antes de insertarlos
            if (!isset($data['localizador'], $data['id_hotel'], $data['email_cliente'])) {
                echo "Faltan datos necesarios.";
                return;
            }

            // Usamos un statement preparado para evitar inyecciones SQL
            $stmt = $this->pdo->prepare("INSERT INTO transfer_reservas (localizador, id_hotel, id_tipo_reserva, email_cliente,
                                    fecha_reserva, fecha_modificacion, id_destino, fecha_entrada, hora_entrada,
                                    numero_vuelo_entrada, origen_vuelo_entrada, hora_vuelo_salida, fecha_vuelo_salida,
                                    num_viajeros, id_vehiculo)
                                    VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Ejecutamos la consulta con los valores del formulario
            $stmt->execute([
                $data['localizador'],
                $data['id_hotel'],
                $data['id_tipo_reserva'],
                $data['email_cliente'],
                $data['id_destino'],
                $data['fecha_entrada'],
                $data['hora_entrada'],
                $data['numero_vuelo_entrada'],
                $data['origen_vuelo_entrada'],
                $data['hora_vuelo_salida'],
                $data['fecha_vuelo_salida'],
                $data['num_viajeros'],
                $data['id_vehiculo']
            ]);

            echo "Reserva creada con éxito.";
        } catch (PDOException $e) {
            echo "Error al crear la reserva: " . $e->getMessage();
        }
    }

    // Método para mostrar detalles de una reserva específica
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

                // Mostrar detalles de la reserva
                echo "Detalles de la reserva: <br>";
                echo "Localizador: " . $reserva->getLocalizador() . "<br>";
                // Mostrar más detalles según necesites...
            } else {
                echo "Reserva no encontrada.";
            }

        } catch (PDOException $e) {
            echo "Error al obtener la reserva: " . $e->getMessage();
        }
    }

    // Método para modificar una reserva existente
    public function modificarReserva($data)
    {
        try {
            // Validar que los datos necesarios estén presentes
            if (!isset($data['id_reserva'], $data['fecha_entrada'], $data['hora_entrada'], $data['num_viajeros'])) {
                echo "Faltan datos para modificar la reserva.";
                return;
            }

            // Consulta preparada para actualizar la reserva
            $stmt = $this->pdo->prepare("UPDATE transfer_reservas SET
                fecha_entrada = ?,
                hora_entrada = ?,
                num_viajeros = ?
                WHERE id_reserva = ?");

            // Ejecutar la consulta
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

    // Método para eliminar una reserva
    public function eliminarReserva($id_reserva)
    {
        try {
            // Verificar si la reserva puede ser cancelada (por ejemplo, más de 48 horas antes)
            $stmt = $this->pdo->prepare("SELECT fecha_entrada FROM transfer_reservas WHERE id_reserva = ?");
            $stmt->execute([$id_reserva]);
            $reserva = $stmt->fetch();

            if ($reserva) {
                $fecha_entrada = new DateTime($reserva['fecha_entrada']);
                $hoy = new DateTime();

                // Si la reserva está dentro de las 48 horas, no permitir la cancelación
                if ($hoy->diff($fecha_entrada)->days <= 2) {
                    echo "No se puede cancelar la reserva, ya que está dentro de las 48 horas.";
                    return;
                }

                // Eliminar la reserva
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

    // Método para obtener reservas por fecha (por día, semana, mes)
    public function obtenerReservasPorFecha($fecha_inicio, $fecha_fin)
    {
        try {
            // Consulta para obtener las reservas dentro del rango de fechas
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_reservas WHERE fecha_entrada BETWEEN ? AND ?");
            $stmt->execute([$fecha_inicio, $fecha_fin]);

            // Array para almacenar las reservas dentro del rango
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

            return $reservas; // Devolvemos el array de reservas
        } catch (PDOException $e) {
            echo "Error al obtener las reservas: " . $e->getMessage();
        }
    }
}

?>
