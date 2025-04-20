<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$volverUrl = '/cliente/home';
if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador') {
    $volverUrl = '/admin/home';
}

// Simulación de reservas por día (esto debe venir del controlador en producción)
$reservasPorDia = [
    '2025-04-01' => 1,
    '2025-04-05' => 2,
    '2025-04-10' => 3,
    '2025-04-15' => 1,
    '2025-04-20' => 2,
    '2025-04-22' => 1,
    '2025-04-30' => 2,
];

$year = 2025;
$month = 4;
$daysInMonth = date('t', strtotime("$year-$month-01"));
$firstDayOfWeek = date('N', strtotime("$year-$month-01"));

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Reservas - Abril 2025</title>
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 600px; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; height: 60px; }
        th { background-color: #f0f0f0; }
        .reserva { background-color: #d1ffd1; font-weight: bold; }
    </style>
</head>
<body>

<h2>🗓️ Calendario de Reservas - Abril 2025</h2>
<p>Como administrador, puedes ver las reservas de los usuarios en el calendario.</p>

<table>
    <thead>
        <tr>
            <th>Lun</th>
            <th>Mar</th>
            <th>Mié</th>
            <th>Jue</th>
            <th>Vie</th>
            <th>Sáb</th>
            <th>Dom</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            $day = 1;
            $currentDay = 1;
            $cellCount = 1;

            // Espacios vacíos antes del primer día del mes
            for ($i = 1; $i < $firstDayOfWeek; $i++, $cellCount++) {
                echo "<td></td>";
            }

            // Días del mes
            for ($day = 1; $day <= $daysInMonth; $day++, $cellCount++) {
                $fecha = sprintf('%04d-%02d-%02d', $year, $month, $day);
                $reservaCount = $reservasPorDia[$fecha] ?? 0;
                $class = $reservaCount > 0 ? 'reserva' : '';
                $label = $reservaCount > 0 ? "$day ($reservaCount)" : $day;
                echo "<td class='$class'>$label</td>";

                // Nueva fila cada 7 días
                if ($cellCount % 7 === 0) echo "</tr><tr>";
            }

            // Completar fila final si es necesario
            while ($cellCount % 7 !== 1) {
                echo "<td></td>";
                $cellCount++;
            }
            ?>
        </tr>
    </tbody>
</table>

<p><a href="<?= $volverUrl ?>">&larr; Volver al Panel</a></p>

</body>
</html>
