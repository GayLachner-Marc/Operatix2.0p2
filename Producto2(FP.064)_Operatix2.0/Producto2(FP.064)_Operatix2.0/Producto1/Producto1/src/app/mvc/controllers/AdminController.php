<?php

require_once 'app/mvc/controllers/ClienteController.php';

use app\mvc\controllers\ClienteController;

class AdminController
{
    public function editarUsuario()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID de usuario no especificado.";
            header("Location: /admin/usuarios");
            exit;
        }

        $clienteController = new ClienteController();
        $usuario = $clienteController->obtenerClientePorId($_GET['id']);

        if (!$usuario) {
            $_SESSION['error'] = "❌ Usuario no encontrado.";
            header("Location: /admin/usuarios");
            exit;
        }

        include 'app/mvc/views/Admin/editar_usuario.php';
    }

    public function actualizarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $data = $_POST;

            // Validar contraseña solo si se ha rellenado
            if (!empty($data['password']) && $data['password'] !== $data['confirm_password']) {
                $_SESSION['error'] = "⚠️ Las contraseñas no coinciden.";
                header("Location: /admin/usuarios/editar?id=$id");
                exit;
            }

            $clienteController = new ClienteController();
            $clienteController->modificarCliente($id, $data, '/admin/usuarios');

            $_SESSION['mensaje'] = "✅ Usuario actualizado correctamente.";
            exit;
        }

        // Si no es POST
        $_SESSION['error'] = "Método no permitido.";
        header("Location: /admin/usuarios");
        exit;
    }
}
