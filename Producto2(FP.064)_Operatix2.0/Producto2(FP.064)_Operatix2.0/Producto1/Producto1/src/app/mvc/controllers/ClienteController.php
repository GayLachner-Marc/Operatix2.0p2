<?php
namespace app\mvc\controllers;

use PDO;
use PDOException;

class ClienteController
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    public function registrarCliente($data)
    {
        try {
            // Validar campos requeridos
            $camposRequeridos = ['nombre', 'apellido1', 'direccion', 'codigoPostal', 'ciudad', 'pais', 'email', 'password', 'confirm_password', 'tipo_cliente'];
            foreach ($camposRequeridos as $campo) {
                if (empty($data[$campo])) {
                    $_SESSION['error'] = "Todos los campos marcados son obligatorios.";
                    header('Location: /cliente/registro');
                    exit();
                }
            }
    
            // Validar contraseñas
            if ($data['password'] !== $data['confirm_password']) {
                $_SESSION['error'] = "Las contraseñas no coinciden.";
                header('Location: /cliente/registro');
                exit();
            }
    
            // Verificar si el correo ya existe
            $stmt = $this->pdo->prepare("SELECT id_viajero FROM transfer_viajeros WHERE email = ?");
            $stmt->execute([$data['email']]);
            if ($stmt->fetch()) {
                $_SESSION['error'] = "Ya existe un usuario registrado con ese correo.";
                header('Location: /cliente/registro');
                exit();
            }
    
            // Insertar nuevo cliente
            $stmt = $this->pdo->prepare("
                INSERT INTO transfer_viajeros (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, tipo_cliente)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
    
            $passwordHasheada = password_hash($data['password'], PASSWORD_DEFAULT);
    
            $stmt->execute([
                $data['nombre'],
                $data['apellido1'],
                $data['apellido2'] ?? '',
                $data['direccion'],
                $data['codigoPostal'],
                $data['ciudad'],
                $data['pais'],
                $data['email'],
                $passwordHasheada,
                $data['tipo_cliente']
            ]);
    
            $_SESSION['success'] = "Cliente registrado con éxito. ¡Ahora puedes iniciar sesión!";
            header('Location: /cliente/login');
            exit();
            
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error al registrar cliente: " . $e->getMessage();
            header('Location: /cliente/registro');
            exit();
        }
    }    

    public function obtenerClientePorId($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_viajeros WHERE id_viajero = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener el cliente: " . $e->getMessage();
        }
    }

    public function modificarCliente($id, $data, $redirect = '/cliente/perfil')
    {
        try {
            if (empty($id)) {
                $_SESSION['error'] = "❌ ID de usuario no proporcionado.";
                header("Location: /admin/usuarios");
                exit();
            }
    
            $campos = [];
            $valores = [];
    
            if (!empty($data['nombre'])) {
                $campos[] = "nombre = ?";
                $valores[] = $data['nombre'];
            }
    
            if (!empty($data['correo'])) {
                $campos[] = "email = ?";
                $valores[] = $data['correo'];
            }
    
            if (!empty($data['password'])) {
                if (!empty($data['confirm_password']) && $data['password'] === $data['confirm_password']) {
                    $campos[] = "password = ?";
                    $valores[] = password_hash($data['password'], PASSWORD_DEFAULT);
                } else {
                    $_SESSION['error'] = "⚠️ Las contraseñas no coinciden.";
                    header("Location: /admin/usuarios/editar?id=" . $id);
                    exit();
                }
            }
    
            if (!empty($campos)) {
                $valores[] = $id;
                $sql = "UPDATE transfer_viajeros SET " . implode(", ", $campos) . " WHERE id_viajero = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($valores);
    
                $_SESSION['mensaje'] = "✅ Usuario actualizado correctamente.";
            } else {
                $_SESSION['error'] = "⚠️ No se enviaron campos para actualizar.";
            }
    
            header("Location: $redirect");
            exit();
    
        } catch (PDOException $e) {
            $_SESSION['error'] = "❌ Error al actualizar el cliente: " . $e->getMessage();
            header("Location: /admin/usuarios/editar?id=" . $id);
            exit();
        }
    }
    

    
    public function login($data)
    {
        $correo = $data['correo'];
        $password = $data['password'];

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_viajeros WHERE email = ?");
            $stmt->execute([$correo]);
            $fila = $stmt->fetch();
            if ($fila && password_verify($password, $fila['password'])) {
                $_SESSION['cliente_id'] = $fila['id_viajero'];
                $_SESSION['cliente_nombre'] = $fila['nombre'];
                $_SESSION['tipo_cliente'] = $fila['tipo_cliente'] ?? 'cliente';
                $_SESSION['email'] = $fila['email'];

                if ($_SESSION['tipo_cliente'] === 'administrador') {
                    header("Location: /admin/home");
                } else {
                    header("Location: /cliente/home");
                }
                exit();
            } else {
                $_SESSION['error'] = "Credenciales incorrectas.";
                header("Location: /cliente/login");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error al autenticar el cliente: " . $e->getMessage();
        }
    }

    public function obtenerTodosLosClientes()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM transfer_viajeros");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los clientes: " . $e->getMessage();
            return [];
        }
    }

    public function eliminarCliente($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM transfer_viajeros WHERE id_viajero = ?");
            $stmt->execute([$id]);
            header("Location: /admin/usuarios");
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el cliente: " . $e->getMessage();
        }
    }
    
    public function editarPerfil($data)
    {
        try {
            $id = $_SESSION['cliente_id'];
            $nombre = $data['nombre'] ?? '';
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? null;

            if (empty($nombre) || empty($email)) {
                echo "Nombre y correo son obligatorios.";
                return;
            }

            if ($password) {
                // Si se envía contraseña, actualizar también
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("UPDATE transfer_viajeros SET nombre = ?, email = ?, password = ? WHERE id_viajero = ?");
                $stmt->execute([$nombre, $email, $passwordHash, $id]);
            } else {
                // Si no, solo nombre y correo
                $stmt = $this->pdo->prepare("UPDATE transfer_viajeros SET nombre = ?, email = ? WHERE id_viajero = ?");
                $stmt->execute([$nombre, $email, $id]);
            }

            // Actualizar sesión si el correo ha cambiado
            $_SESSION['email'] = $email;

            $_SESSION['mensaje'] = "Perfil actualizado correctamente.";

            header("Location: /cliente/perfil");
            exit;

        } catch (PDOException $e) {
            echo "Error al actualizar el perfil: " . $e->getMessage();
        }
    }
}
