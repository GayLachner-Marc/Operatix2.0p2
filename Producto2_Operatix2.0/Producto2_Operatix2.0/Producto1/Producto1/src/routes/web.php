<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelPanelController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReporteController;


// 🔧 Ruta de prueba DB
Route::get('/', function () {
    return redirect()->route('login.form');
});

// 🧱 Página en construcción
Route::get('/en_construccion', fn() => view('en_construccion'))->name('en_construccion');

// 📲 Login / Registro General
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// 👤 Cliente: Registro, Login, Panel, Perfil
Route::prefix('cliente')->group(function () {
    Route::get('/registro', [ClienteController::class, 'formRegistro'])->name('cliente.registro.form');
    Route::post('/registro', [ClienteController::class, 'registrar'])->name('cliente.registro');
    
    Route::get('/login', [ClienteController::class, 'showLogin'])->name('cliente.login');
    Route::post('/login', [ClienteController::class, 'login']);

    Route::get('/home', [ClienteController::class, 'home'])->name('cliente.home')->middleware('auth');
    Route::get('/logout', [ClienteController::class, 'logout'])->name('cliente.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/perfil', [ClienteController::class, 'viewProfile']);
        Route::get('/editar', [PerfilController::class, 'editar'])->name('cliente.editar');
        Route::post('/editar', [PerfilController::class, 'actualizar'])->name('cliente.actualizar');
    });
});

// 🏨 Hotel: Registro y Panel
Route::prefix('hotel')->group(function () {
    Route::get('/registro', [HotelController::class, 'formularioRegistro'])->name('hotel.registro.form');
    Route::post('/registro', [HotelController::class, 'registrar'])->name('hotel.registro');
    Route::get('/home', [HotelPanelController::class, 'home'])->name('hotel.panel');
});

// 📆 Reservas
Route::prefix('reserva')->middleware('auth')->group(function () {
    Route::get('/listar', [ReservaController::class, 'listar'])->name('reserva.listar');
    Route::get('/crear', [ReservaController::class, 'formCrear'])->name('reserva.crear.form');
    Route::post('/crear', [ReservaController::class, 'crear'])->name('reserva.crear');

    Route::get('/detalle/{id}', [ReservaController::class, 'detalle'])->name('reserva.detalle');
    Route::post('/eliminar', [ReservaController::class, 'eliminar'])->name('reserva.eliminar');

    Route::get('/modificar', [ReservaController::class, 'formModificar'])->name('reserva.modificar.form');
    Route::post('/modificar', [ReservaController::class, 'modificar'])->name('reserva.modificar');

    Route::get('/confirmar', [ReservaController::class, 'formConfirmar'])->name('reserva.confirmar.form');
    Route::post('/confirmar', [ReservaController::class, 'confirmar'])->name('reserva.confirmar');

    Route::get('/calendario', [ReservaController::class, 'mostrarCalendario'])->name('calendario.reservas');
});

// 🔐 Administración
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/reportes', [ReporteController::class, 'index'])->name('admin.reportes');

    // Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editar'])->name('usuarios.editar');
    Route::post('/usuarios/actualizar', [UsuarioController::class, 'actualizar'])->name('usuarios.actualizar');
    Route::get('/usuarios/eliminar', [UsuarioController::class, 'eliminar'])->name('usuarios.eliminar'); // ⚠️ usar POST idealmente

    // Vehículos
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/crear', [VehiculoController::class, 'formCrear'])->name('vehiculos.crear.form');
    Route::post('/vehiculos/crear', [VehiculoController::class, 'crear'])->name('vehiculos.crear');
    Route::get('/vehiculos/{id}/editar', [VehiculoController::class, 'formEditar'])->name('vehiculos.editar.form');
    Route::post('/vehiculos/editar', [VehiculoController::class, 'actualizar'])->name('vehiculos.editar');
    Route::get('/vehiculos/eliminar', [VehiculoController::class, 'eliminar'])->name('vehiculos.eliminar');

    // Hoteles
    Route::get('/hoteles', [HotelController::class, 'index'])->name('hoteles.index');
    Route::get('/hoteles/crear', [HotelController::class, 'formCrear'])->name('hoteles.crear.form');
    Route::post('/hoteles/crear', [HotelController::class, 'crear'])->name('hoteles.crear');
    Route::get('/hoteles/{id}/editar', [HotelController::class, 'formEditar'])->name('hoteles.editar.form');
    Route::post('/hoteles/editar', [HotelController::class, 'editar'])->name('hoteles.editar');
    Route::get('/hoteles/eliminar', [HotelController::class, 'eliminar'])->name('hoteles.eliminar'); // ⚠️ usar POST idealmente
});
