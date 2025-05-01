<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header('Location: /cliente/login');
    exit;
} ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Hoteles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
    <style>
        .gestion-hoteles-container {
            background: #e8fbe5;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 128, 0, 0.15);
            max-width: 900px;
            margin: 60px auto;
            box-sizing: border-box;
        }

        h1 {
            color: #2e7d32;
            text-align: center;
            margin-bottom: 25px;
        }

        .gestion-hoteles-container p a {
            color: #388e3c;
            font-weight: bold;
            text-decoration: none;
        }

        .gestion-hoteles-container a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 128, 0, 0.05);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #c8e6c9;
            color: #2e7d32;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td a {
            color: #388e3c;
            font-weight: bold;
            text-decoration: none;
            margin: 0 5px;
        }

        td a:hover {
            text-decoration: underline;
        }

        .volver-panel {
            text-align: center;
            margin-top: 30px;
        }

        .volver-panel a {
            color: #3b7c3b;
            font-weight: bold;
            text-decoration: none;
        }

        .volver-panel a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="gestion-hoteles-container">
    <h1>Gestión de Hoteles</h1>

    <p><a href="/admin/hoteles/crear">+ Añadir nuevo hotel</a></p>

    <table>
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
                            <a href="/admin/hoteles/editar?id=<?= urlencode($hotel['id_hotel']) ?>">Editar</a> |
                            <a href="/admin/hoteles/eliminar?id=<?= urlencode($hotel['id_hotel']) ?>" onclick="return confirm('¿Estás seguro de eliminar este hotel?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No hay hoteles registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="volver-panel">
        <a href="/admin/home">← Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
