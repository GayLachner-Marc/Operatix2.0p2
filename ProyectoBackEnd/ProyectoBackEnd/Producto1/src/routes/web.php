<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Conexión exitosa a la base de datos.";
    } catch (\Exception $e) {
        return "❌ Error de conexión: " . $e->getMessage();
    }
});
Route::get('/debug-cache', function () {
    dd(config('cache.default')); // esto debería mostrar: "file"
});
