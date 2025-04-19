<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>

    <h2>Registro de Usuario</h2>

    <form action="/cliente/registro" method="POST">

        <div>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div>
            <label for="apellido1">Primer Apellido:</label><br>
            <input type="text" id="apellido1" name="apellido1" required>
        </div>

        <div>
            <label for="apellido2">Segundo Apellido:</label><br>
            <input type="text" id="apellido2" name="apellido2">
        </div>

        <div>
            <label for="direccion">Dirección:</label><br>
            <input type="text" id="direccion" name="direccion" required>
        </div>

        <div>
            <label for="codigoPostal">Código Postal:</label><br>
            <input type="text" id="codigoPostal" name="codigoPostal" required>
        </div>

        <div>
            <label for="ciudad">Ciudad:</label><br>
            <input type="text" id="ciudad" name="ciudad" required>
        </div>

        <div>
            <label for="pais">País:</label><br>
            <input type="text" id="pais" name="pais" required>
        </div>

        <div>
            <label for="email">Correo electrónico:</label><br>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="confirm_password">Confirmar contraseña:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <div>
            <label for="tipo_cliente">Tipo de Cliente:</label><br>
            <select name="tipo_cliente" id="tipo_cliente" required>
                <option value="particular">Particular</option>
                <option value="corporativo">Corporativo</option>
            </select>
        </div>

        <br>
        <button type="submit">Registrarse</button>
    </form>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        echo "<p style='color:green;'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    ?>

    <p>¿Ya tienes una cuenta? <a href="/cliente/login">Inicia sesión</a></p>

</body>
</html>
