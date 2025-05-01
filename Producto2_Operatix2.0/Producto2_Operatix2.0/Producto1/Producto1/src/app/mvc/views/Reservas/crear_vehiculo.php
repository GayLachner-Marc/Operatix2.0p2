<?php
use app\mvc\controllers\VehiculoController;

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header("Location: /cliente/login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear nuevo Vehiculo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>

<form action="/admin/vehiculos/crear" method="POST">
    
<h2>Añadir nuevo vehículo</h2>
   <label for="id_vehiculo">Id del Vehiculo:</label>
   <input type="text" name="id_vehiculo" required>

    <label for="description">Descripción del vehículo:</label>
    <input type="text" name="description" required>
    
    <label for="email_conductor">Email del conductor:</label>
    <input type="email" name="email_conductor" required>
    
    <label for="password">Contraseña del conductor:</label>
    <input type="password" name="password" required>
    
    <button type="submit">Añadir Vehículo</button>

    <div class="volver-menu">
        <a href="/admin/vehiculos">← Volver a la gestión de vehiculos</a>
    </div>
</form>
