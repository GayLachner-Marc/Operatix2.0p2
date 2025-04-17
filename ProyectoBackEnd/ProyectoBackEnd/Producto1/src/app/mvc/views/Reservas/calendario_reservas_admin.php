<!-- calendario_reservas_admin.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Calendario de Reservas</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
    
    <!-- Aquí puedes agregar un enlace a una librería de JavaScript para el calendario si se requiere -->
    <!-- Ejemplo: <script src="path_to_calendar_lib.js"></script> -->
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Calendario de Reservas</h2>

    <!-- Instrucciones para el administrador -->
    <p>Como administrador, puedes ver las reservas de los usuarios en el calendario.</p>

    <!-- Aquí se muestra el calendario de reservas -->
    <div id="calendar">
        <!-- Este es el calendario que se debe renderizar dinámicamente con PHP y/o JavaScript -->
        <!-- Por ejemplo, podríamos usar una librería de calendario para facilitar la visualización -->
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
                <!-- Este tbody se llenará dinámicamente con las fechas de las reservas -->
                <?php
                // Ejemplo de cómo se podría generar el calendario dinámicamente
                // Aquí se obtendrían las reservas de la base de datos y se mostrarían las fechas ocupadas

                // Suponiendo que tenemos un array de fechas con reservas
                // Esta parte puede ajustarse según cómo tengas organizadas las fechas de las reservas
                $reservas = [
                    "2023-12-01" => "Reserva 1",
                    "2023-12-05" => "Reserva 2",
                    "2023-12-10" => "Reserva 3"
                ];

                // La fecha actual, para generar el calendario
                $fecha_actual = new DateTime();

                // Aquí generamos el calendario para el mes actual
                for ($i = 1; $i <= 31; $i++) {
                    // Generamos una fecha con el día actual
                    $dia_actual = $fecha_actual->format('Y-m') . "-" . str_pad($i, 2, "0", STR_PAD_LEFT);
                    
                    echo "<tr>";

                    // Verificamos si este día tiene una reserva
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

    <!-- Enlace para volver al panel de administración -->
    <p><a href="panel_admin.php">Volver al Panel de Administración</a></p>

</body>
</html>
