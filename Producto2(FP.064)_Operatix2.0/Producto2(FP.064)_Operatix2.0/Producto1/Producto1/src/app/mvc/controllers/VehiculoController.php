<?php
// Incluir el modelo de Vehiculo para interactuar con la base de datos
namespace app\mvc\controllers;

use app\mvc\models\Vehiculo;

require_once __DIR__ . '/../models/Vehiculo.php';


// Controlador para las operaciones relacionadas con los vehículos
class VehiculoController
{

    private $pdo;

    // Constructor para inicializar la conexión PDO
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Método para listar todos los vehículos
    public function listarVehiculos()
    {
        try {
            // Ejecutamos una consulta para obtener todos los vehículos
            $stmt = $this->pdo->query("SELECT * FROM transfer_vehiculo");

            // Mostramos los vehículos
            while ($fila = $stmt->fetch()) {
                // Creamos un objeto Vehiculo por cada fila de la base de datos
                $vehiculo = new Vehiculo(
                    $fila['id_vehiculo'],
                    $fila['description'],
                    $fila['email_conductor'],
                    $fila['password']
                );

                // Aquí puedes mostrar los detalles de cada vehículo o pasarlos a una vista
                echo "Vehículo ID: " . $vehiculo->getIdVehiculo() . " - Descripción: " . $vehiculo->getDescripcion() . "<br>";
            }

        } catch (PDOException $e) {
            echo "Error al obtener los vehículos: " . $e->getMessage();
        }
    }

    // Método para ver los detalles de un vehículo específico
    public function verVehiculo($id_vehiculo)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_vehiculo WHERE id_vehiculo = ?");
            $stmt->execute([$id_vehiculo]);

            $fila = $stmt->fetch();

            if ($fila) {
                // Creamos el objeto Vehiculo con los datos encontrados
                $vehiculo = new Vehiculo(
                    $fila['id_vehiculo'],
                    $fila['description'],
                    $fila['email_conductor'],
                    $fila['password']
                );

                // Mostrar detalles del vehículo
                echo "ID Vehículo: " . $vehiculo->getIdVehiculo() . "<br>";
                echo "description: " . $vehiculo->getDescription() . "<br>";
                echo "Email Conductor: " . $vehiculo->getEmailConductor() . "<br>";
            } else {
                echo "Vehículo no encontrado.";
            }

        } catch (PDOException $e) {
            echo "Error al obtener los detalles del vehículo: " . $e->getMessage();
        }
    }

    // Método para registrar un nuevo vehículo (admin)
 
    public function crearVehiculo($data)
    {
    // Verificamos que tengamos los datos necesarios para la creación
      if (!isset($data['description'], $data['email_conductor'], $data['password'])) {
        echo "Faltan datos para crear el vehículo.";
        return;
    }

      try {
        // Usamos un statement preparado para evitar inyecciones SQL
        $stmt = $this->pdo->prepare("INSERT INTO transfer_vehiculo (description, email_conductor, password) VALUES (?, ?, ?)");

        // Ejecutamos la consulta con los valores del formulario
        $stmt->execute([
            $data['description'],
            $data['email_conductor'],
            $data['password']
        ]);

        $_SESSION['mensaje'] = "Vehiculo registrado con éxito.";
        header('Location: /admin/vehiculos');
        exit();
    } catch (PDOException $e) {
        echo "Error al registrar el vehiculo: " . $e->getMessage();
    }
    }

    // Método para actualizar la información de un vehículo
    public function actualizarVehiculo($data)
    {
        // Verificamos que tengamos los datos necesarios para la actualización
        if (!isset($data['id_vehiculo'], $data['description'], $data['email_conductor'], $data['password'])) {
            echo "Faltan datos para actualizar el vehículo.";
            return;
        }

        try {
            // Usamos un statement preparado para evitar inyecciones SQL
            $stmt = $this->pdo->prepare("UPDATE transfer_vehiculo SET Descripcion = ?, email_conductor = ?, password = ? WHERE id_vehiculo = ?");

            // Ejecutamos la consulta para actualizar la fila correspondiente
            $stmt->execute([
                $data['description'],
                $data['email_conductor'],
                $data['password'],
                $data['id_vehiculo']
            ]);

            echo "Vehículo actualizado con éxito.";
        } catch (PDOException $e) {
            echo "Error al actualizar el vehículo: " . $e->getMessage();
        }
    }
    public function obtenerTodosLosVehiculos()
    {
    
        try {

             $stmt = $this->pdo->query("SELECT * FROM transfer_vehiculo");
             return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
           echo "Error al obtener los vehículos: " . $e->getMessage();
        return [];
    }
    }
    public function eliminarVehiculo($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM transfer_precios WHERE id_vehiculo = ?");
            $stmt->execute([$id]);
    
            $stmt = $this->pdo->prepare("DELETE FROM transfer_vehiculo WHERE id_vehiculo = ?");
            $stmt->execute([$id]);
    
        } catch (\PDOException $e) {
            // Puedes guardar este mensaje en sesión o log
            $_SESSION['error_eliminar'] = $e->getMessage();
        }
    }
    
    // Método para mostrar el formulario de edición de un vehículo
public function editarVehiculo($id_vehiculo)
{
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM transfer_vehiculo WHERE id_vehiculo = ?");
        $stmt->execute([$id_vehiculo]);

        $vehiculo = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($vehiculo) {
            // Cargamos la vista del formulario de edición
            require_once __DIR__ . '/../views/Reservas/editar_vehiculos.php';
        } else {
            echo "Vehículo no encontrado.";
        }

    } catch (\PDOException $e) {
        echo "Error al cargar el vehículo para edición: " . $e->getMessage();
    }
}

}

?>
