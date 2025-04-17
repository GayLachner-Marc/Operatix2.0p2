<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Hotel</title>
</head>
<body>

    <h1>Registrar Nuevo Hotel</h1>

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
