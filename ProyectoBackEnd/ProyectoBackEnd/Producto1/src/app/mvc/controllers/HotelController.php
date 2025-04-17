<?php
// Incluir el modelo de Hotel para interactuar con la base de datos
namespace app\mvc\controllers;
use Hotel;

require_once __DIR__ . '/../models/Hotel.php';

// Controlador para las operaciones relacionadas con los hoteles
class HotelController
{

    private $pdo;

    // Constructor para inicializar la conexión PDO
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Método para listar todos los hoteles
    public function listarHoteles()
    {
        try {
            // Ejecutamos la consulta para obtener todos los hoteles
            $stmt = $this->pdo->query("SELECT * FROM tranfer_hotel");

            // Mostramos los hoteles
            while ($fila = $stmt->fetch()) {
                // Creamos un objeto Hotel por cada fila de la base de datos
                $hotel = new Hotel(
                    $fila['id_hotel'],
                    $fila['id_zona'],
                    $fila['Comision'],
                    $fila['usuario'],
                    $fila['password']
                );

                // Aquí se podrían mostrar los detalles del hotel o pasarlos a una vista
                echo "Hotel ID: " . $hotel->getIdHotel() . " - Zona: " . $hotel->getIdZona() . "<br>";
            }

        } catch (PDOException $e) {
            echo "Error al obtener los hoteles: " . $e->getMessage();
        }
    }

    // Método para ver los detalles de un hotel específico
    public function verHotel($id_hotel)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tranfer_hotel WHERE id_hotel = ?");
            $stmt->execute([$id_hotel]);

            $fila = $stmt->fetch();

            if ($fila) {
                // Creamos el objeto Hotel con los datos encontrados
                $hotel = new Hotel(
                    $fila['id_hotel'],
                    $fila['id_zona'],
                    $fila['Comision'],
                    $fila['usuario'],
                    $fila['password']
                );

                // Mostrar detalles del hotel
                echo "ID Hotel: " . $hotel->getIdHotel() . "<br>";
                echo "Comisión: " . $hotel->getComision() . "<br>";
                echo "Usuario: " . $hotel->getUsuario() . "<br>";
                // Otros detalles de interés aquí
            } else {
                echo "Hotel no encontrado.";
            }

        } catch (PDOException $e) {
            echo "Error al obtener los detalles del hotel: " . $e->getMessage();
        }
    }

    // Método para registrar un nuevo hotel (admin)
    public function registrarHotel($data)
    {
        // Validamos los datos antes de insertarlos
        if (!isset($data['id_zona'], $data['comision'], $data['usuario'], $data['password'])) {
            echo "Faltan datos necesarios.";
            return;
        }

        try {
            // Usamos un statement preparado para evitar inyecciones SQL
            $stmt = $this->pdo->prepare("INSERT INTO tranfer_hotel (id_zona, Comision, usuario, password) VALUES (?, ?, ?, ?)");

            // Ejecutamos la consulta con los valores del formulario
            $stmt->execute([
                $data['id_zona'],
                $data['comision'],
                $data['usuario'],
                $data['password']
            ]);

            echo "Hotel registrado con éxito.";
        } catch (PDOException $e) {
            echo "Error al registrar el hotel: " . $e->getMessage();
        }
    }

    // Método para actualizar la información de un hotel
    public function actualizarHotel($data)
    {
        // Verificamos que tengamos los datos necesarios para la actualización
        if (!isset($data['id_hotel'], $data['id_zona'], $data['comision'], $data['usuario'], $data['password'])) {
            echo "Faltan datos para actualizar el hotel.";
            return;
        }

        try {
            // Usamos un statement preparado para evitar inyecciones SQL
            $stmt = $this->pdo->prepare("UPDATE tranfer_hotel SET id_zona = ?, Comision = ?, usuario = ?, password = ? WHERE id_hotel = ?");

            // Ejecutamos la consulta para actualizar la fila correspondiente
            $stmt->execute([
                $data['id_zona'],
                $data['comision'],
                $data['usuario'],
                $data['password'],
                $data['id_hotel']
            ]);

            echo "Hotel actualizado con éxito.";
        } catch (PDOException $e) {
            echo "Error al actualizar el hotel: " . $e->getMessage();
        }
    }
}

?>
