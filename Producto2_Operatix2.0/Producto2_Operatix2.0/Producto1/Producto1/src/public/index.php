<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell
 */

// Verifica que el archivo se esté ejecutando en el contexto adecuado (en la carpeta public)
if ($_SERVER['REQUEST_URI'] == '/favicon.ico') {
    return;
}

// Carga las dependencias de Composer
require __DIR__.'/../vendor/autoload.php';

// Arranca la aplicación Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Obtiene el Kernel y maneja la solicitud
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Captura la solicitud HTTP
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Envia la respuesta al navegador
$response->send();

// Termina el proceso
$kernel->terminate($request, $response);
