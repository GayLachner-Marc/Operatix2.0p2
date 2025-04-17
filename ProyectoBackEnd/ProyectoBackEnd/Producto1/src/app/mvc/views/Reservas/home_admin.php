<!-- home_admin.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para soportar caracteres especiales -->
    <meta charset="UTF-8">
    
    <!-- Meta para que la página sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título de la página -->
    <title>Panel de Administración</title>
    
    <!-- Enlace a los estilos CSS para dar formato a la página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Título principal de la página -->
    <h2>Bienvenido al Panel de Administración</h2>

    <!-- Mensaje introductorio -->
    <p>Desde este panel, el administrador puede gestionar todas las reservas, usuarios y otros aspectos del sistema.</p>

    <!-- Menú de opciones -->
    <div class="menu">
        <ul>
            <li><a href="calendario_reservas_admin.php">Ver Calendario de Reservas</a></li>
            <li><a href="crear_reserva_admin.php">Crear Nueva Reserva</a></li>
            <li><a href="gestionar_usuarios.php">Gestionar Usuarios</a></li>
            <li><a href="gestionar_hoteles.php">Gestionar Hoteles</a></li>
            <li><a href="gestionar_vehiculos.php">Gestionar Vehículos</a></li>
            <li><a href="reportes.php">Ver Reportes de Actividad</a></li>
        </ul>
    </div>

    <!-- Enlace para cerrar sesión -->
    <p><a href="logout.php">Cerrar sesión</a></p>

</body>
</html>
