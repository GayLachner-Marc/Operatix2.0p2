<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="login-container">
        

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <form action="{{ route('login') }}" method="POST">
        <h1>Iniciar sesión</h1>
            @csrf
            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Ingresar</button>

             <!-- Botón para ir al registro -->
             <p class="register-link">
                ¿No tienes cuenta? <a href="/cliente/registro">Regístrate aquí</a>
            </p>

        </form>
    </div>
</body>
</html>
