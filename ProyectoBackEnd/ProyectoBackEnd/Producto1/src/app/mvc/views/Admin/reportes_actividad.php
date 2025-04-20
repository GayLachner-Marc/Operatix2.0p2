<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header('Location: /cliente/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes de Actividad</title>
    <style>
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        h1 {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <h1>📊 Reportes de Actividad</h1>

    <h2>Resumen</h2>
    <ul>
        <li><strong>Total de reservas:</strong> <?= isset($totalReservas) ? $totalReservas : 0 ?></li>
        <li><strong>Total de hoteles registrados:</strong> <?= isset($totalHoteles) ? $totalHoteles : 0 ?></li>
        <li><strong>Zona más reservada:</strong> <?= isset($zonaMasReservada['nombre_zona']) ? $zonaMasReservada['nombre_zona'] . ' (' . $zonaMasReservada['total'] . ' reservas)' : 'N/D (0 reservas)' ?></li>
    </ul>

    <h2>Últimas Reservas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email Cliente</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha Reserva</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ultimasReservas as $reserva): ?>
                <tr>
                    <td><?= $reserva['id_reserva'] ?></td>
                    <td><?= $reserva['email_cliente'] ?></td>
                    <td><?= $reserva['origen_vuelo_entrada'] ?? 'N/D' ?></td>
                    <td><?= $reserva['nombre_zona'] ?? 'N/D' ?></td>
                    <td><?= $reserva['fecha_reserva'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Últimos Hoteles Registrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Zona</th>
                <th>Comisión</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ultimosHoteles as $hotel): ?>
                <tr>
                    <td><?= $hotel['id_hotel'] ?></td>
                    <td><?= $hotel['nombre_zona'] ?? $hotel['id_zona'] ?></td>
                    <td><?= $hotel['Comision'] ?></td>
                    <td><?= $hotel['usuario'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Reservas por Día (7 últimos días)</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Total de Reservas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservasPorDia as $fila): ?>
                <tr>
                    <td><?= $fila['fecha'] ?></td>
                    <td><?= $fila['total'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="/admin/home">← Volver al panel de administración</a></p>
</body>
</html>