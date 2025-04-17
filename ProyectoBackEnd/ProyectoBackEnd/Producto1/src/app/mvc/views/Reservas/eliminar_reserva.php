<?php
// Incluir el archivo del controlador para acceder a la lógica
require_once 'controllers/ReservaController.php';

// Verificar si el ID de la reserva está presente en la URL
if (isset($_GET['id'])) {
    // Obtener el ID de la reserva desde la URL
    $id_reserva = $_GET['id'];

    // Crear una instancia del controlador ReservaController
    $controller = new ReservaController();

    // Llamar al método eliminarReserva pasando el ID de la reserva
    $controller->eliminarReserva($id_reserva);
    
    // Redirigir a la lista de reservas después de eliminar
    header("Location: listar.php");
    exit;
} else {
    // Si no se pasa el ID de la reserva, mostrar un error o redirigir
    echo "No se ha encontrado la reserva.";
}
?>
