<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Hoteles</title>
</head>
<body>

    <h1>Gestión de Hoteles</h1>

    <p><a href="/admin/hoteles/crear">+ Añadir nuevo hotel</a></p>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Zona</th>
                <th>Comisión</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($hoteles)): ?>
                <?php foreach ($hoteles as $hotel): ?>
                    <tr>
                        <td><?= htmlspecialchars($hotel['id_hotel']) ?></td>
                        <td><?= htmlspecialchars($hotel['id_zona']) ?></td>
                        <td><?= htmlspecialchars($hotel['Comision']) ?>%</td>
                        <td><?= htmlspecialchars($hotel['usuario']) ?></td>
                        <td>
                            <a href="/admin/hoteles/editar?id=<?= $hotel['id_hotel'] ?>">Editar</a> |
                            <a href="/admin/hoteles/eliminar?id=<?= $hotel['id_hotel'] ?>" onclick="return confirm('¿Estás seguro de eliminar este hotel?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No hay hoteles registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="/admin/home">← Volver al panel</a></p>

</body>
</html>
