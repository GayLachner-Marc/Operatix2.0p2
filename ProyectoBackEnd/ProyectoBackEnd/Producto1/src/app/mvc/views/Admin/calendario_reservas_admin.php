<!-- calendario_reservas_admin.php -->
<?php
session_start();

// Establecer redirección según el tipo de cliente
$volverUrl = '/cliente/home';
if (isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] === 'administrador') {
    $volverUrl = '/admin/home';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Reservas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Calendario de Reservas</h2>
    <p>Como administrador, puedes ver las reservas de los usuarios en el calendario.</p>

    <div id="calendar">
        <table>
            <thead>
                <tr>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                    <th>Domingo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reservas = [
                    "2023-12-01" => "Reserva 1",
                    "2023-12-05" => "Reserva 2",
                    "2023-12-10" => "Reserva 3"
                ];

                $fecha_actual = new DateTime();

                for ($i = 1; $i <= 31; $i++) {
                    $dia_actual = $fecha_actual->format('Y-m') . "-" . str_pad($i, 2, "0", STR_PAD_LEFT);
                    echo "<tr>";

                    if (isset($reservas[$dia_actual])) {
                        echo "<td style='background-color: lightgreen;'>$i<br>" . $reservas[$dia_actual] . "</td>";
                    } else {
                        echo "<td>$i</td>";
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <p><a href="<?= $volverUrl ?>">← Volver al Panel</a></p>

</body>
</html>
