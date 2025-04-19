<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../controllers/ReservaController.php';

use app\mvc\controllers\ReservaController;

if (isset($_SESSION['cliente_id']) && isset($_GET['id'])) {
    $id_reserva = $_GET['id'];
    $controller = new ReservaController();

    // Verificar si es administrador o cliente
    if ($_SESSION['tipo_cliente'] === 'administrador') {
        $redirect = '/admin/home';  // o '/reserva/listar' si tienes una vista para admins
    } else {
        $redirect = '/reserva/listar';
    }

    $controller->eliminarReserva($id_reserva);

    header("Location: $redirect");
    exit;
} else {
    echo "⚠️ No tienes permiso para realizar esta acción o falta el ID de la reserva.";
}
?>
