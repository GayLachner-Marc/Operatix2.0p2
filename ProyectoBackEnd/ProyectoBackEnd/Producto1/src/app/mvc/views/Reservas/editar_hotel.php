<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hotel</title>
</head>
<body>

    <h1>Editar Hotel</h1>

    <form action="/admin/hoteles/editar" method="POST">
        <!-- Campo oculto para mantener el ID -->
        <input type="hidden" name="id_hotel" value="<?= htmlspecialchars($hotel['id_hotel']) ?>">

        <p>
            <label for="id_zona">ID Zona:</label>
            <input type="text" name="id_zona" id="id_zona" value="<?= htmlspecialchars($hotel['id_zona']) ?>" required>
        </p>

        <p>
            <label for="comision">Comisión (%):</label>
            <input type="text" name="comision" id="comision" value="<?= htmlspecialchars($hotel['Comision']) ?>" required>
        </p>

        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?= htmlspecialchars($hotel['usuario']) ?>" required>
        </p>

        <p>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" value="<?= htmlspecialchars($hotel['password']) ?>" required>
        </p>

        <p>
            <button type="submit">Guardar Cambios</button>
        </p>
    </form>

    <p><a href="/admin/hoteles">← Volver a la gestión de hoteles</a></p>

</body>
</html>
