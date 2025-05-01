<?php
use app\mvc\controllers\HotelController;

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['tipo_cliente']) || $_SESSION['tipo_cliente'] !== 'administrador') {
    header("Location: /cliente/login");
    exit();
}

require_once BASE_PATH . '/app/mvc/controllers/HotelController.php';
$controller = new HotelController($pdo);
$zonas = $controller->obtenerZonas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>




<form action="/admin/hoteles/editar" method="POST">

<h2>Editar Hotel</h2>
    <input type="hidden" name="id_hotel" value="<?= htmlspecialchars($hotel['id_hotel']) ?>">

    <p>
        <label for="id_zona">Zona:</label>
        <select name="id_zona" id="id_zona" required>
            <?php foreach ($zonas as $zona): ?>
                <option value="<?= $zona['id_zona'] ?>" <?= $zona['id_zona'] == $hotel['id_zona'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($zona['nombre_zona']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>


    <p>
        <label for="comision">Comisión (%):</label>
        <input type="text" name="comision" id="comision" value="<?= htmlspecialchars($hotel['Comision']) ?>" required>
    </p>

    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?= htmlspecialchars($hotel['usuario']) ?>" required>
    </p>

    <p>
        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" name="password" id="password" placeholder="Deja en blanco si no cambia">
    </p>

    <p>
        <button type="submit">Guardar Cambios</button>
    </p>
    <div class="volver-menu">
        <a href="/admin/hoteles">← Volver a la gestión de hoteles</a>
    </div>
</form>



</body>
</html>
