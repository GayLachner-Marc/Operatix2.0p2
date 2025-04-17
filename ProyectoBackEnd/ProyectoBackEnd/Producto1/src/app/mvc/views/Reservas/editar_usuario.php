<!-- editar_usuario.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h2>Editar Usuario</h2>

    <?php if (isset($cliente)): ?>
        <form action="/admin/usuarios/editar" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id_viajero']) ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required><br><br>

            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($cliente['email']) ?>" required><br><br>

            <label for="password">Nueva Contraseña (opcional):</label>
            <input type="password" name="password" id="password"><br><br>

            <button type="submit">Guardar Cambios</button>
        </form>
    <?php else: ?>
        <p>Usuario no encontrado.</p>
    <?php endif; ?>

    <p><a href="/admin/usuarios">← Volver a Gestión de Usuarios</a></p>
</body>
</html>
