<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\ClienteRepository;
use App\Models\Hotel;
use App\Models\Reserva;
use App\Models\Vehiculo;

// Ruta de prueba para la conexión a la base de datos
Route::get('/', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Conexión exitosa a la base de datos.";
    } catch (\Exception $e) {
        return "❌ Error de conexión: " . $e->getMessage();
    }
});

// Rutas de Cliente
Route::get('/cliente/login', [ClienteController::class, 'showLogin'])->name('cliente.login');
Route::post('/cliente/login', [ClienteController::class, 'login']);

Route::get('/cliente/registro', [ClienteController::class, 'showRegistration'])->name('cliente.registro');
Route::post('/cliente/registro', [ClienteController::class, 'registrarCliente']);

Route::get('/cliente/home', [ClienteController::class, 'home'])->middleware('auth');
Route::get('/cliente/perfil', [ClienteController::class, 'viewProfile'])->middleware('auth');
Route::get('/cliente/logout', [ClienteController::class, 'logout'])->name('cliente.logout');

Route::get('/cliente/editar', [ClienteController::class, 'editProfile'])->name('cliente.edit');
Route::post('/cliente/editar', [ClienteController::class, 'updateProfile']);

// Rutas de Hotel
Route::get('/hotel/registro', [HotelController::class, 'showRegistration'])->name('hotel.registro');
Route::get('/hotel/home', [HotelController::class, 'home'])->middleware('auth');

// Rutas de Reserva
Route::get('/reserva/listar', [ReservaController::class, 'listarReservas'])->middleware('auth');
Route::get('/reserva/crear', [ReservaController::class, 'createReserva'])->middleware('auth');
Route::post('/reserva/crear', [ReservaController::class, 'storeReserva'])->middleware('auth');

Route::get('/reserva/detalle/{id}', [ReservaController::class, 'verReserva'])->middleware('auth');
Route::get('/reserva/eliminar/{id}', [ReservaController::class, 'eliminarReserva'])->middleware('auth');

// Rutas de administración (solo para administradores)
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Rutas de administración de usuarios
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/usuarios', [ClienteController::class, 'listarClientes'])->name('admin.usuarios');
    Route::get('/usuarios/editar/{id}', [ClienteController::class, 'editarCliente'])->name('admin.usuarios.editar');
    Route::post('/usuarios/editar/{id}', [ClienteController::class, 'updateCliente']);
    Route::get('/usuarios/eliminar/{id}', [ClienteController::class, 'eliminarCliente']);

    // Rutas de administración de vehículos
    Route::get('/vehiculos', [VehiculoController::class, 'listarVehiculos'])->name('admin.vehiculos');
    Route::get('/vehiculos/crear', [VehiculoController::class, 'crearVehiculo']);
    Route::post('/vehiculos/crear', [VehiculoController::class, 'crearVehiculo']);
    Route::get('/vehiculos/editar/{id}', [VehiculoController::class, 'editarVehiculo']);
    Route::post('/vehiculos/editar/{id}', [VehiculoController::class, 'actualizarVehiculo']);
    Route::get('/vehiculos/eliminar/{id}', [VehiculoController::class, 'eliminarVehiculo']);

    // Rutas de administración de hoteles
    Route::get('/hoteles', [HotelController::class, 'listarHoteles'])->name('admin.hoteles');
    Route::get('/hoteles/crear', [HotelController::class, 'registrarHotel']);
    Route::post('/hoteles/crear', [HotelController::class, 'registrarHotel']);
    Route::get('/hoteles/editar/{id}', [HotelController::class, 'actualizarHotel']);
    Route::post('/hoteles/editar/{id}', [HotelController::class, 'actualizarHotel']);
    Route::get('/hoteles/eliminar/{id}', [HotelController::class, 'eliminarHotel']);
});

// Ruta para página en construcción
Route::get('/en_construccion', function () {
    return view('en_construccion');
});
