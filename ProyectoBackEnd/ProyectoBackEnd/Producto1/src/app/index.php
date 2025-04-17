<?php
// index.php - Punto de entrada principal para la aplicación

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Ruta base del proyecto
define('BASE_PATH', __DIR__);

// Cargar controladores
require_once BASE_PATH . '/mvc/controllers/ClienteController.php';
require_once BASE_PATH . '/mvc/controllers/ReservaController.php';
// Agrega más si los necesitas

// Usar namespaces
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

    // Puedes añadir más rutas aquí como /cliente/registro, /reserva/crear, etc.

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
            include BASE_PATH . '/mvc/views/reservas/crear_reserva_cliente.php';
        } else {
            header('Location: /cliente/login');
            exit();
        }
        break;
    
    case '/cliente/perfil':
        if (isset($_SESSION['cliente_id'])) {
            include BASE_PATH . '/mvc/views/reservas/modificar_Reserva.php';
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
                
            

    

    default:
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
        break;

    
}
