<?php
// index.php - Punto de entrada principal para la aplicación

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/app/mvc/controllers/HotelController.php';
require_once BASE_PATH . '/app/mvc/controllers/ClienteController.php';
require_once BASE_PATH . '/app/mvc/controllers/ReservaController.php';
require_once BASE_PATH . '/app/mvc/controllers/VehiculoController.php';
// Carga de la conexión PDO
require_once BASE_PATH . '/config_php/conexion.php';
$pdo = conectar();

use app\mvc\controllers\HotelController;
use app\mvc\controllers\ClienteController;
use app\mvc\controllers\ReservaController;
use app\mvc\controllers\VehiculoController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
    case '/':
    case '/cliente/login':
        if ($method === 'POST') {
            $controller = new ClienteController();
            $controller->login($_POST);
        } else {
            include BASE_PATH . '/app/mvc/views/Clientes/login.php'; 
        }
        break;

    case '/cliente/registro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new ClienteController();
            $controller->registrarCliente($_POST);
        } else {
            include BASE_PATH . '/app/mvc/views/Clientes/registro.php';
        }
        break;
        
    case '/hotel/registro':
        include BASE_PATH . '/app/mvc/views/Clientes/registro_hotel.php';
        break;

    case '/cliente/home':
        if (isset($_SESSION['cliente_id'])) {
            include BASE_PATH . '/app/mvc/views/Reservas/home_cliente.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/hotel/home':
        if (isset($_SESSION['cliente_id']) && $_SESSION['tipo_cliente'] === 'hotel') {
            include BASE_PATH . '/app/mvc/views/Reservas/home_hotel.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/cliente/editar':
        if ($method === 'POST' && isset($_SESSION['cliente_id'])) {
            $controller = new ClienteController();
            $controller->editarPerfil($_POST);
            header('Location: /cliente/perfil');
            exit();
        }
        break;
    
    case '/admin/perfil/editar':
        if ($method === 'POST' && $_SESSION['tipo_cliente'] === 'administrador') {
            $controller = new ClienteController();
            $controller->editarPerfil($_POST);
            header("Location: /admin/perfil");
            exit();
        }
        break;

    case '/reserva/listar':
        if (isset($_SESSION['cliente_id'])) {
            $controller = new ReservaController($pdo); // asegúrate de tener $pdo disponible
            $reservas = $controller->listarReservas();
            include BASE_PATH . '/app/mvc/views/Reservas/listar.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
    break;

    case '/reserva/crear':
        if (isset($_SESSION['cliente_id'])) {
            $pdo = new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin");
            $controller = new ReservaController($pdo);
    
            if ($method === 'POST') {
                $controller->crearReserva($_POST);
            } else {
                include BASE_PATH . '/app/mvc/views/Reservas/crear_reserva_cliente.php';
            }
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;    

    case '/reserva/crear/admin':
        if (isset($_SESSION['cliente_id']) && $_SESSION['tipo_cliente'] === 'administrador') {
            $controller = new ReservaController($pdo);
            if ($method === 'POST') {
                $controller->crearReserva($_POST);
            } else {
                include BASE_PATH . '/app/mvc/views/Reservas/crear_reserva_admin.php';
            }
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;
    
    case '/reserva/calendario':
        if (isset($_SESSION['cliente_id']) && $_SESSION['tipo_cliente'] === 'administrador') {
            include BASE_PATH . '/app/mvc/views/Admin/calendario_reservas_admin.php';
        } else {
            header('Location: /cliente/home');
            exit();
        }
        break;

    case '/reserva/detalle':
        if (isset($_SESSION['cliente_id']) && isset($_GET['id'])) {
            include BASE_PATH . '/app/mvc/views/Reservas/detalle_reserva.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/reserva/eliminar':
        if (isset($_SESSION['cliente_id']) && isset($_GET['id'])) {
            include BASE_PATH . '/app/mvc/views/Reservas/eliminar_reserva.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/cliente/perfil':
        if (isset($_SESSION['cliente_id'])) {
            $controller = new ClienteController();
            $cliente = $controller->obtenerClientePorId($_SESSION['cliente_id']);
            include BASE_PATH . '/app/mvc/views/Clientes/perfil.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/cliente/logout':
        session_destroy();
        header('Location: /cliente/login');
        exit();
        break;

    case '/admin/home':
        if (isset($_SESSION['cliente_id']) && $_SESSION['tipo_cliente'] === 'administrador') {
            include BASE_PATH . '/app/mvc/views/Admin/home_admin.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/admin/vehiculos':
        if ($_SESSION['tipo_cliente'] === 'administrador') {
            $controller = new VehiculoController($pdo);
            $vehiculos = $controller->obtenerTodosLosVehiculos();
            include BASE_PATH . '/app/mvc/views/Reservas/gestionar_vehiculos.php';
        } else {
                header('Location: /cliente/login');
                exit();
        }
        break;
        
        case '/admin/vehiculos/crear':
            if ($method === 'POST') {
                $controller = new VehiculoController($pdo);  // Aquí le pasamos $pdo
                $controller->crearVehiculo($_POST);
                header('Location: /admin/vehiculos');
            } else {
                include BASE_PATH . '/app/mvc/views/Reservas/crear_vehiculo.php';  // Este archivo puede ser innecesario
            }
            break;
        
// Ruta de edición de vehículos
  // Ruta de edición de vehículos
    case '/admin/vehiculos/editar':
    // Asegúrate de pasar el PDO al controlador
         $controller = new VehiculoController($pdo);  // Aquí le pasamos $pdo
         if ($method === 'GET' && isset($_GET['id'])) {
        // Obtener datos del vehículo para edición
        $vehiculo = $controller->verVehiculo($_GET['id']);
        // Aquí cargamos la vista de edición del vehículo, asegúrate de tener el formulario adecuado
        include BASE_PATH . '/app/mvc/views/Reservas/editar_vehiculos.php'; // Este es el archivo que debe contener el formulario de edición
        } elseif ($method === 'POST') {
        // Actualizar el vehículo
        $controller->actualizarVehiculo($_POST);
        header('Location: /admin/vehiculos');
        }
        break;


    case '/admin/vehiculos/eliminar':
        if (isset($_GET['id'])) {
            $controller = new VehiculoController($pdo);
            $controller->eliminarVehiculo($_GET['id']);
            header('Location: /admin/vehiculos');
        }
        break;

    case '/admin/usuarios':
        if ($_SESSION['tipo_cliente'] === 'administrador') {
            $controller = new ClienteController();
            $clientes = $controller->obtenerTodosLosClientes();
            include BASE_PATH . '/app/mvc/views/Admin/gestionar_usuarios.php';
        } else {
            header("Location: /cliente/login");
            exit();
        }
        break;

    case '/admin/usuarios/editar':
        $controller = new ClienteController();
        if ($method === 'GET' && isset($_GET['id'])) {
            $cliente = $controller->obtenerClientePorId($_GET['id']);
            include BASE_PATH . '/app/mvc/views/Admin/editar_usuario.php';
        } elseif ($method === 'POST') {
            $controller->modificarCliente($_POST['id'], $_POST, '/admin/usuarios');
        }
        break;

    case '/admin/usuarios/eliminar':
        if (isset($_GET['id']) && $_SESSION['tipo_cliente'] === 'administrador') {
            $controller = new ClienteController();
            $controller->eliminarCliente($_GET['id']);
        }
        break;
        
    default:
        include BASE_PATH . '/app/mvc/views/Reservas/en_construccion.php';
        break;
}
