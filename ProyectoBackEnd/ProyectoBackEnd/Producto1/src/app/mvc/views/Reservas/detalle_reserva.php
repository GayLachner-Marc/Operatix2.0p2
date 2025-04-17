<!-- detalle_reserva.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Detalle de la Reserva</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Detalles de la Reserva</h2>

    <!-- Aquí comenzamos a mostrar los detalles de la reserva -->
    <table>
        <tr>
            <th>Tipo de Trayecto</th>
            <td><?php echo htmlspecialchars($tipo_reserva); ?></td>
        </tr>
        <tr>
            <th>Fecha de Entrada</th>
            <td><?php echo htmlspecialchars($fecha_entrada); ?></td>
        </tr>
        <tr>
            <th>Hora de Entrada</th>
            <td><?php echo htmlspecialchars($hora_entrada); ?></td>
        </tr>
        <tr>
            <th>Número de Viajeros</th>
            <td><?php echo htmlspecialchars($num_viajeros); ?></td>
        </tr>
        <tr>
            <th>Hotel de Destino</th>
            <td><?php echo htmlspecialchars($hotel_destino); ?></td>
        </tr>
        <tr>
            <th>Número de Vuelo</th>
            <td><?php echo htmlspecialchars($numero_vuelo); ?></td>
        </tr>
        <tr>
            <th>Hora del Vuelo</th>
            <td><?php echo htmlspecialchars($hora_vuelo); ?></td>
        </tr>
        <tr>
            <th>Origen del Vuelo</th>
            <td><?php echo htmlspecialchars($origen_vuelo); ?></td>
        </tr>
        <tr>
            <th>Correo del Cliente</th>
            <td><?php echo htmlspecialchars($email_cliente); ?></td>
        </tr>
    </table>

    <!-- Mostrar el estado de la reserva -->
    <p><strong>Estado de la Reserva:</strong> <?php echo htmlspecialchars($estado_reserva); ?></p>

    <!-- Si es el administrador, puede editar o cancelar la reserva -->
    <?php if ($is_admin) { ?>
        <a href="editar_reserva.php?id_reserva=<?php echo $id_reserva; ?>">Editar Reserva</a>
        <a href="cancelar_reserva.php?id_reserva=<?php echo $id_reserva; ?>" style="color:red;">Cancelar Reserva</a>
    <?php } ?>

    <!-- Enlace para volver al panel de cliente o administrador -->
    <p><a href="/cliente/home">Volver al Panel de Cliente</a></p>
    <p><a href="/cliente/home">Volver al Panel de Administración</a></p>

</body>
</html>
