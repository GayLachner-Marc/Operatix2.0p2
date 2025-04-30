<!-- calendario_reservas.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Reservas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlaza el archivo CSS para estilo -->
</head>
<body>

    <h2>Calendario de Reservas</h2>

    <!-- Formularios para seleccionar día, semana o mes -->
    <form action="calendario_reservas.php" method="GET">
        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" required>

        <label for="fecha_fin">Fecha de fin:</label>
        <input type="date" name="fecha_fin" required>

        <button type="submit">Ver Reservas</button>
    </form>

    <?php
    // Llamar al controlador para obtener las reservas
    require_once 'controllers/ReservaController.php';
    $controller = new ReservaController();

    // Verificar si se enviaron las fechas
    if (isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin'])) {
        $fecha_inicio = $_GET['fecha_inicio'];
        $fecha_fin = $_GET['fecha_fin'];

        // Obtener las reservas entre las fechas seleccionadas
        $reservas = $controller->obtenerReservasPorFecha($fecha_inicio, $fecha_fin);

        // Mostrar las reservas en una tabla
        if (!empty($reservas)) {
            echo "<table border='1'>
                    <tr>
                        <th>Localizador</th>
                        <th>Fecha de Entrada</th>
                        <th>Hotel</th>
                        <th>Destino</th>
                    </tr>";

            foreach ($reservas as $reserva) {
                echo "<tr>
                        <td>" . htmlspecialchars($reserva->getLocalizador()) . "</td>
                        <td>" . htmlspecialchars($reserva->getFechaEntrada()) . "</td>
                        <td>" . htmlspecialchars($reserva->getIdHotel()) . "</td>
                        <td>" . htmlspecialchars($reserva->getIdDestino()) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron reservas para el rango seleccionado.</p>";
        }
    }
    ?>

</body>
</html>
