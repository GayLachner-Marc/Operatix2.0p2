
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h1>Editar Vehiculo</h1>


<!-- app/mvc/views/vehiculos/editar.php -->

<h2>Editar Vehículo</h2>

<form method="POST" action="index.php?action=actualizarVehiculo">
    <input type="hidden" name="id_vehiculo" value="<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">

    <label>Descripción:</label>
    <input type="text" name="description" value="<?= htmlspecialchars($vehiculo['description']) ?>"><br><br>

    <label>Email del conductor:</label>
    <input type="email" name="email_conductor" value="<?= htmlspecialchars($vehiculo['email_conductor']) ?>"><br><br>

    <label>Contraseña:</label>
    <input type="password" name="password" value="<?= htmlspecialchars($vehiculo['password']) ?>"><br><br>

    <button type="submit">Actualizar Vehículo</button>
</form>
