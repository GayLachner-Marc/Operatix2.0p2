<!-- crear_vehiculo.php -->
<?php
session_start();
if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header("Location: /cliente/login");
    exit();
}
?>
<h2>Añadir nuevo vehículo</h2>
<form action="/admin/vehiculos/crear" method="POST">
   <label for="id_vehiculo">Id del Vehiculo:</label>
   <input type="text" name="id_vehiculo" required>

    <label for="description">Descripción del vehículo:</label>
    <input type="text" name="description" required>
    
    <label for="email_conductor">Email del conductor:</label>
    <input type="email" name="email_conductor" required>
    
    <label for="password">Contraseña del conductor:</label>
    <input type="password" name="password" required>
    
    <button type="submit">Añadir Vehículo</button>
</form>
