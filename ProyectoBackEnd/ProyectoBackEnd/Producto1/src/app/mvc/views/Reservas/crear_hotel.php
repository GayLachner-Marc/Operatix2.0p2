<!-- crear_hotel.php -->
<?php
session_start();
if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header("Location: /cliente/login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <h1>Registrar Nuevo Hotel</h1>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p style="color:green"><?= $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
    <?php elseif (isset($_SESSION['error'])): ?>
        <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <form action="/admin/hoteles/crear" method="POST">
        <label for="id_zona">ID Zona:</label>
        <input type="number" name="id_zona" id="id_zona" required><br><br>

        <label for="comision">Comisión (%):</label>
        <input type="text" name="comision" id="comision" required><br><br>

        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Registrar Hotel</button>
    </form>

    <p><a href="/admin/hoteles">← Volver a la gestión de hoteles</a></p>

</body>
</html>
