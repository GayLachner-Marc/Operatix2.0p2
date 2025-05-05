<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Reserva</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <div class="formulario-container">
        <h2>➕ Crear Nueva Reserva</h2>
        <p>Formulario para que el hotel cree una nueva reserva.</p>

        <form method="POST" action="/hotel/crear_reserva">
            <label for="id_tipo_reserva">Tipo de Reserva:</label>
            <select name="id_tipo_reserva" id="id_tipo_reserva" required>
                <option value="">Selecciona...</option>
                <option value="1">Ida</option>
                <option value="2">Vuelta</option>
                <option value="3">Ida y Vuelta</option>
            </select><br><br>

            <label for="id_hotel">ID del Hotel:</label>
            <input type="number" name="id_hotel" id="id_hotel" required><br><br>

            <label for="email_cliente">Email del Cliente:</label>
            <input type="email" name="email_cliente" id="email_cliente" required><br><br>

            <label for="fecha_entrada">Fecha de Entrada:</label>
            <input type="date" name="fecha_entrada" id="fecha_entrada" required><br><br>

            <label for="hora_entrada">Hora de Entrada:</label>
            <input type="time" name="hora_entrada" id="hora_entrada"><br><br>

            <label for="num_viajeros">Número de Viajeros:</label>
            <input type="number" name="num_viajeros" id="num_viajeros" required><br><br>

            <label for="numero_vuelo_entrada">Número de Vuelo de Entrada:</label>
            <input type="text" name="numero_vuelo_entrada" id="numero_vuelo_entrada"><br><br>

            <label for="origen_vuelo_entrada">Origen del Vuelo de Entrada:</label>
            <input type="text" name="origen_vuelo_entrada" id="origen_vuelo_entrada"><br><br>

            <label for="fecha_vuelo_salida">Fecha de Vuelo de Salida:</label>
            <input type="date" name="fecha_vuelo_salida" id="fecha_vuelo_salida"><br><br>

            <label for="hora_vuelo_salida">Hora de Vuelo de Salida:</label>
            <input type="time" name="hora_vuelo_salida" id="hora_vuelo_salida"><br><br>

            <label for="id_vehiculo">Vehículo (opcional):</label>
            <input type="number" name="id_vehiculo" id="id_vehiculo"><br><br>

            <label for="id_destino">Destino (opcional):</label>
            <input type="number" name="id_destino" id="id_destino"><br><br>

            <button type="submit">Guardar Reserva</button>
        </form>

        <p><a href="/hotel/home">← Volver al Panel del Hotel</a></p>
    </div>
</body>
</html>
