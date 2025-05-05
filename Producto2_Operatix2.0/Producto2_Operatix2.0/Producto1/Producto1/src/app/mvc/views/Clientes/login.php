<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirección automática si ya está logueado
if (isset($_SESSION['tipo_cliente'])) {
    switch ($_SESSION['tipo_cliente']) {
        case 'administrador':
            header("Location: /admin/home");
            break;
        case 'corporativo':
        case 'particular':
            header("Location: /cliente/home");
            break;
        case 'hotel':
            header("Location: /hotel/home");
            break;
        default:
            header("Location: /cliente/login");
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

    <!-- ✅ Alerta flotante arriba -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert success">
            <?= $_SESSION['success'] ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="login-container">
        <form method="POST" action="/cliente/login">
            <h2>Iniciar sesión</h2>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Acceder</button>

            <p class="register-link">
                ¿No tienes cuenta? <a href="/cliente/registro">Regístrate aquí</a>
            </p>

            <!-- 🏨 Acceso para usuarios de hotel -->
            <p class="register-link">
                ¿Eres un hotel? <a href="/hotel/login">Inicia sesión como hotel</a>
            </p>
        </form>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);
    </script>
</body>
</html>
