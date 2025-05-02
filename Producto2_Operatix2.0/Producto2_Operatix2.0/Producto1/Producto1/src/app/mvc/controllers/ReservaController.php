<?php

namespace app\mvc\controllers;

use PDO;
use PDOException;

class ReservaController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarReservasPorHotel($idHotel)
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT r.*, 
                        d.nombre_zona AS destino_nombre 
                 FROM transfer_reservas r
                 LEFT JOIN transfer_zona d ON r.id_destino = d.id_zona
                 WHERE r.id_hotel = :id OR r.id_destino = :id
                 ORDER BY r.fecha_reserva DESC"
            );
            $stmt->execute(['id' => $idHotel]);
            $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            include BASE_PATH . '/app/mvc/views/Reservas/listar_reservas_hotel.php';
        } catch (PDOException $e) {
            echo "Error al obtener las reservas del hotel: " . $e->getMessage();
        }
    }

    public function crearReserva($data)
    {
        try {
            $localizador = strtoupper(bin2hex(random_bytes(4)));

            $idHotel = $data['id_hotel'] ?? null;
            $idTipoReserva = $data['id_tipo_reserva'] ?? null;
            $emailCliente = $data['email_cliente'] ?? null;
            $fechaEntrada = $data['fecha_entrada'] ?? null;
            $horaEntrada = $data['hora_entrada'] ?? null;
            $numViajeros = $data['num_viajeros'] ?? null;
            $numeroVueloEntrada = $data['numero_vuelo_entrada'] ?? null;
            $origenVueloEntrada = $data['origen_vuelo_entrada'] ?? null;
            $fechaVueloSalida = $data['fecha_vuelo_salida'] ?? null;
            $horaVueloSalida = $data['hora_vuelo_salida'] ?? null;
            $idVehiculo = $data['id_vehiculo'] ?? null;
            $idDestino = $data['id_destino'] ?? $idHotel;

            $stmt = $this->pdo->prepare("INSERT INTO transfer_reservas
                (localizador, id_hotel, id_tipo_reserva, email_cliente, fecha_entrada, hora_entrada,
                numero_vuelo_entrada, origen_vuelo_entrada, fecha_vuelo_salida, hora_vuelo_salida,
                num_viajeros, id_vehiculo, id_destino)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $localizador, $idHotel, $idTipoReserva, $emailCliente, $fechaEntrada,
                $horaEntrada, $numeroVueloEntrada, $origenVueloEntrada, $fechaVueloSalida,
                $horaVueloSalida, $numViajeros, $idVehiculo, $idDestino
            ]);

            header("Location: /hotel/reservas");
            exit();
        } catch (PDOException $e) {
            echo "<p>Error al crear la reserva: " . $e->getMessage() . "</p>";
            
        }
    }
}
