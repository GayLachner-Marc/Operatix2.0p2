<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página en Construcción</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <h2>🚧 ¡Esta página está en construcción!</h2>
    <p>Estamos trabajando en esta sección y estará disponible pronto. ¡Gracias por tu paciencia!</p>

    <?php
        $homeLink = '/';
        if (isset($_SESSION['tipo_cliente'])) {
            if ($_SESSION['tipo_cliente'] === 'administrador') {
                $homeLink = '/admin/home';
            } else {
                $homeLink = '/cliente/home';
            }
        }
    ?>

    <p><a href="<?= $homeLink ?>">← Volver al panel principal</a></p>

</body>
</html>
