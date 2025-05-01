<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$volverUrl = '/cliente/home';
if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador') {
    $volverUrl = '/admin/home';
}

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
    <title>Calendario de Reservas</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

<div class="calendario-container">
    <h2 class="titulo-calendario">📅 Calendario de Reservas - Abril <?= $year ?></h2>
    <p>Como administrador, puedes ver las reservas de los usuarios en el calendario.</p>

    <table class="tabla-calendario">
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
                $cellCount = 1;

                for ($i = 1; $i < $firstDayOfWeek; $i++, $cellCount++) {
                    echo "<td></td>";
                }

                for ($day = 1; $day <= $daysInMonth; $day++, $cellCount++) {
                    $fecha = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    $reservaCount = $reservasPorDia[$fecha] ?? 0;
                    $class = $reservaCount > 0 ? 'reserva' : '';
                    $label = $reservaCount > 0 ? "$day ($reservaCount)" : $day;
                    echo "<td class='$class'>$label</td>";

                    if ($cellCount % 7 === 0) echo "</tr><tr>";
                }

                while ($cellCount % 7 !== 1) {
                    echo "<td></td>";
                    $cellCount++;
                }
                ?>
            </tr>
        </tbody>
    </table>

    <div class="volver-menu">
        <a href="<?= $volverUrl ?>">&larr; Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
