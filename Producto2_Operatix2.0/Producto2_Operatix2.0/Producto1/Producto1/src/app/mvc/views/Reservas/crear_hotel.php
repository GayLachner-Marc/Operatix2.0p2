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



<?php if (isset($_SESSION['mensaje'])): ?>
    <p style="color:green"><?= $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
<?php elseif (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="/admin/hoteles/crear" method="POST">
<h2>Registrar Nuevo Hotel</h2>
<label for="id_zona">Zona:</label>
<select name="id_zona" id="id_zona" required>
    <option value="">Seleccione una zona</option>
    <?php foreach ($zonas as $zona): ?>
        <option value="<?= $zona['id_zona'] ?>"><?= htmlspecialchars($zona['nombre_zona']) ?></option>
    <?php endforeach; ?>
</select>
<br><br>


    <label for="comision">Comisión (%):</label>
    <input type="text" name="comision" id="comision" required><br><br>

    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" id="usuario" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required><br><br>

    <button type="submit">Registrar Hotel</button>
    <div class="volver-menu">
        <a href="/admin/hoteles">← Volver a la gestión de hoteles</a>
    </div>
</form>



</body>
</html>
