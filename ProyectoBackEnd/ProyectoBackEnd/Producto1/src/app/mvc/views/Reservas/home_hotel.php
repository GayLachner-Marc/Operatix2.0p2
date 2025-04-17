<!-- home_hotel.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Panel de Hotel</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Bienvenido al Panel del Hotel</h2>

    <!-- Mensaje introductorio -->
    <p>Desde este panel, puedes gestionar las reservas de los clientes y ver la información relevante de tu hotel.</p>

    <!-- Menú de opciones -->
    <div class="menu">
        <ul>
            <li><a href="reservas_hotel.php">Ver Reservas</a></li>
            <li><a href="crear_reserva_hotel.php">Realizar Nueva Reserva</a></li>
            <li><a href="perfil_hotel.php">Editar Perfil del Hotel</a></li>
        </ul>
    </div>

    <!-- Enlace para cerrar sesión -->
    <p><a href="logout.php">Cerrar sesión</a></p>

</body>
</html>
