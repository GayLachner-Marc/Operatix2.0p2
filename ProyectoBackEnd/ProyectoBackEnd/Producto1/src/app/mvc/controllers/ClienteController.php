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
            $stmt = $this->pdo->prepare("
                INSERT INTO transfer_viajeros (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, tipo_cliente)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $passwordHasheada = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt->execute([
                $data['nombre'],
                $data['apellido1'],
                $data['apellido2'],
                $data['direccion'],
                $data['codigoPostal'],
                $data['ciudad'],
                $data['pais'],
                $data['email'],
                $passwordHasheada,
                $data['tipo_cliente'] ?? 'particular'
            ]);

            $_SESSION['mensaje'] = "Cliente registrado con éxito.";
            header('Location: /cliente/login');
            exit();
        } catch (PDOException $e) {
            echo "Error al registrar cliente: " . $e->getMessage();
        }
    }

    public function obtenerClientePorId($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_viajeros WHERE id_viajero = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los datos del cliente: " . $e->getMessage();
        }
    }

    public function modificarCliente($id, $data, $redirect = '/cliente/perfil')
    {
        try {
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
                $campos[] = "password = ?";
                $valores[] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if (!empty($campos)) {
                $valores[] = $id;
                $sql = "UPDATE transfer_viajeros SET " . implode(", ", $campos) . " WHERE id_viajero = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($valores);
            }

            header("Location: $redirect");
            exit();
        } catch (PDOException $e) {
            echo "Error al actualizar el cliente: " . $e->getMessage();
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
                $_SESSION['tipo_cliente'] = $fila['tipo_cliente'];
                $_SESSION['email'] = $fila['email']; // ✅ AÑADE ESTO


                if ($fila['tipo_cliente'] === 'administrador') {
                    header("Location: /admin/home");
                } elseif ($fila['tipo_cliente'] === 'corporativo') {
                    header("Location: /corporativo/home");
                } else {
                    header("Location: /cliente/home");
                }
                exit();
            } else {
                echo "Credenciales incorrectas.";
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
            header('Location: /admin/usuarios');
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el cliente: " . $e->getMessage();
        }
    }

    public function editarCliente($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM transfer_viajeros WHERE id_viajero = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener el cliente: " . $e->getMessage();
        }
    }
}
