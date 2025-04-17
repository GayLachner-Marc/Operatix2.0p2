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

    public function modificarCliente($id, $data)
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

        header('Location: /cliente/perfil');
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
            $usuario = $stmt->fetch();

            // Versión provisional SIN password_hash (solo para probar)
            if ($usuario && $usuario['password'] === $password) {
                $_SESSION['cliente_id'] = $usuario['id_viajero'];
                $_SESSION['cliente_nombre'] = $usuario['nombre'];
                $_SESSION['tipo_cliente'] = 'particular';

                header("Location: /cliente/home");
                exit();
            } else {
                $error = "Correo o contraseña incorrectos";
                include BASE_PATH . "/app/mvc/views/clientes/login.php";
            }
        } catch (PDOException $e) {
            echo "Error en login: " . $e->getMessage();
        }
    }
}
