<?php
// index.php - Punto de entrada principal para la aplicación



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Ruta base del proyecto
define('BASE_PATH', __DIR__);

// Cargar controladores
require_once BASE_PATH . '/mvc/controllers/HotelController.php';
require_once BASE_PATH . '/mvc/controllers/ClienteController.php';
require_once BASE_PATH . '/mvc/controllers/ReservaController.php';
// Agrega más si los necesitas

// Usar namespaces
use app\mvc\controllers\HotelController;
use app\mvc\controllers\ClienteController;
use app\mvc\controllers\ReservaController;

// Obtener ruta y método
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Enrutador simple
switch ($uri) {
    case '/':
    case '/cliente/login':
        if ($method === 'POST') {
            $controller = new ClienteController();
            $controller->login($_POST);
        } else {
            include BASE_PATH . '/mvc/views/clientes/login.php';
        }
        break;

    case '/cliente/home':
        if (isset($_SESSION['cliente_id'])) {
            include BASE_PATH . '/mvc/views/reservas/home_cliente.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/reserva/listar':
        if (isset($_SESSION['cliente_id'])) {
            include BASE_PATH . '/mvc/views/reservas/listar.php';
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
                    // Aquí iría la lógica para crear la reserva
                    $controller->crearReserva($_POST); // Asegúrate de tener este método
                } else {
                    include BASE_PATH . '/mvc/views/reservas/crear_reserva_cliente.php';
                }
            } else {
                header('Location: /cliente/login');
                exit();
            }
            break;
        
        

    case '/cliente/perfil':
        if (isset($_SESSION['cliente_id'])) {
            $controller = new ClienteController();
            $cliente = $controller->obtenerClientePorId($_SESSION['cliente_id']);
            include BASE_PATH . '/mvc/views/clientes/perfil.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/cliente/modificar':
        if ($method === 'POST') {
            if (isset($_SESSION['cliente_id'])) {
                $controller = new ClienteController();
                $controller->modificarCliente($_SESSION['cliente_id'], $_POST);
            } else {
                header('Location: /cliente/login');
                exit();
            }
        }
        break;

    case '/cliente/logout':
        session_destroy();
        header('Location: /cliente/login');
        exit();
        break;

    case '/reserva/modificar':
        if ($method === 'GET' && isset($_GET['id'])) {
            $controller = new ReservaController();
            $reserva = $controller->obtenerReservaPorId($_GET['id']);

            if ($reserva) {
                include BASE_PATH . '/mvc/views/reservas/modificar_Reserva.php';
            } else {
                echo "<h1>Reserva no encontrada</h1>";
            }
        } elseif ($method === 'POST') {
            if (isset($_POST['id_reserva'])) {
                $controller = new ReservaController();
                $controller->modificarReserva($_POST['id_reserva'], $_POST);
            } else {
                echo "<h1>Solicitud inválida</h1>";
            }
        }
        break;

    case '/admin/home':
        if (isset($_SESSION['cliente_id']) && $_SESSION['tipo_cliente'] === 'administrador') {
            include BASE_PATH . '/mvc/views/reservas/home_admin.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/reserva/calendario':
        if (isset($_SESSION['cliente_id']) && $_SESSION['tipo_cliente'] === 'administrador') {
            include BASE_PATH . '/mvc/views/reservas/calendario_reservas_admin.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

    case '/admin/usuarios':
        $controller = new ClienteController();
        $clientes = $controller->obtenerTodosLosClientes();
        include BASE_PATH . '/mvc/views/reservas/gestionar_usuarios.php';
        break;

    case '/admin/vehiculos':
        include BASE_PATH . '/mvc/views/reservas/gestionar_vehiculos.php';
        break;

    case '/admin/reportes':
        include BASE_PATH . '/mvc/views/reservas/reportes.php';
        break;

    case '/admin/usuarios/eliminar':
        if (isset($_GET['id']) && $_SESSION['tipo_cliente'] === 'administrador') {
            $controller = new ClienteController();
            $controller->eliminarCliente($_GET['id']);
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;

        case '/admin/usuarios/editar':
            $controller = new ClienteController();
        
            if ($method === 'GET' && isset($_GET['id'])) {
                $cliente = $controller->editarCliente($_GET['id']);
                include BASE_PATH . '/mvc/views/reservas/editar_usuario.php';
                exit();
            } elseif ($method === 'POST') {
                $controller->modificarCliente($_POST['id'], $_POST, '/admin/usuarios'); // <- aquí pasamos la redirección
                exit();
            }
            break;
    
            case '/admin/hoteles':
                $controller = new HotelController(new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin"));
                $hoteles = $controller->listarHoteles();
                include BASE_PATH . '/mvc/views/reservas/gestionar_hoteles.php';
                break;
            
            
                case '/admin/hoteles/editar':
                    $controller = new HotelController(new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin"));
                
                    if ($method === 'GET' && isset($_GET['id'])) {
                        $hotel = $controller->verHotel($_GET['id']);
                        include BASE_PATH . '/mvc/views/reservas/editar_hotel.php'; // Asegúrate de tener esta vista creada
                        exit();
                    } elseif ($method === 'POST') {
                        $controller->actualizarHotel($_POST);
                        header('Location: /admin/hoteles');
                        exit();
                    }
                    break;

                    case '/admin/hoteles/eliminar':
                        if (isset($_GET['id'])) {
                            $controller = new HotelController(new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin"));
                            $controller->eliminarHotel($_GET['id']);
                            header('Location: /admin/hoteles');
                            exit();
                        }
                        break;
                    
                
                
                case '/admin/hoteles/crear':
                    $controller = new HotelController(new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin"));
                    if ($method === 'POST') {
                        $controller->registrarHotel($_POST);
                        header('Location: /admin/hoteles');
                        exit();
                    } else {
                        include BASE_PATH . '/mvc/views/reservas/crear_hotel.php';
                    }
                    break;
            
                    case '/admin/hoteles/editar':
                        if ($method === 'GET' && isset($_GET['id'])) {
                            $controller = new HotelController(new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin"));
                            $hotel = $controller->verHotel($_GET['id']); // suponiendo que devuelve datos
                            include BASE_PATH . '/mvc/views/reservas/editar_hotel.php';
                        } elseif ($method === 'POST') {
                            $controller = new HotelController(new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin"));
                            $controller->actualizarHotel($_POST);
                            header('Location: /admin/hoteles');
                            exit();
                        }
                        break;
                    
                    case '/admin/hoteles/eliminar':
                        if (isset($_GET['id'])) {
                            $controller = new HotelController(new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin"));
                            $controller->eliminarHotel($_GET['id']);
                            header('Location: /admin/hoteles');
                            exit();
                        }
                        break;
                        
        
        

    case '/admin/usuarios/actualizar':
        if ($method === 'POST') {
            $controller = new ClienteController();
            $controller->modificarCliente($_POST['id_viajero'], $_POST);
            header('Location: /admin/usuarios');
            exit();
        }
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
        break;
}