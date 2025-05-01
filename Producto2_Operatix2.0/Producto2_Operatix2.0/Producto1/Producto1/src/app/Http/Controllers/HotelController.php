<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Zona; // Asumiendo que tienes el modelo Zona
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HotelController extends Controller
{
    // Listar todos los hoteles
    public function listarHoteles()
    {
        // Usamos Eloquent para obtener todos los hoteles
        $hoteles = Hotel::all();
        return view('admin.gestionar_hoteles', compact('hoteles'));
    }

    // Ver detalles de un hotel específico
    public function verHotel($id_hotel)
    {
        // Usamos Eloquent para buscar el hotel por su ID
        $hotel = Hotel::find($id_hotel);

        if (!$hotel) {
            return redirect()->route('admin.hoteles')->with('error', '❌ Hotel no encontrado.');
        }

        return view('admin.ver_hotel', compact('hotel'));
    }

    // Registrar un nuevo hotel
    public function registrarHotel(Request $request)
    {
        // Validación de datos del formulario
        $request->validate([
            'id_zona' => 'required|integer',
            'comision' => 'required|numeric',
            'usuario' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            // Crear un nuevo hotel usando el modelo Hotel de Laravel
            $hotel = new Hotel();
            $hotel->id_zona = $request->id_zona;
            $hotel->Comision = $request->comision;
            $hotel->usuario = $request->usuario;
            $hotel->password = Hash::make($request->password); // Usamos Laravel para hacer el hash de la contraseña
            $hotel->save();

            return redirect()->route('admin.hoteles')->with('success', 'Hotel registrado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar el hotel: ' . $e->getMessage());
        }
    }

    // Actualizar un hotel existente
    public function actualizarHotel(Request $request, $id_hotel)
    {
        // Usamos Eloquent para obtener el hotel
        $hotel = Hotel::find($id_hotel);

        if (!$hotel) {
            return redirect()->route('admin.hoteles')->with('error', '❌ Hotel no encontrado.');
        }

        // Validación de datos del formulario
        $request->validate([
            'id_zona' => 'required|integer',
            'comision' => 'required|numeric',
            'usuario' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $hotel->id_zona = $request->id_zona;
        $hotel->Comision = $request->comision;
        $hotel->usuario = $request->usuario;

        // Si se proporciona una nueva contraseña, la actualizamos
        if ($request->filled('password')) {
            $hotel->password = Hash::make($request->password);
        }

        $hotel->save();

        return redirect()->route('admin.hoteles')->with('success', 'Hotel actualizado con éxito.');
    }

    // Obtener las zonas disponibles
    public function obtenerZonas()
    {
        // Usamos Eloquent para obtener las zonas
        $zonas = Zona::all();
        return $zonas;
    }

    // Obtener los últimos hoteles (limite)
    public function obtenerUltimosHoteles($limite = 5)
    {
        // Usamos Eloquent para obtener los últimos hoteles
        $hoteles = Hotel::with('zona')->orderBy('id_hotel', 'desc')->take($limite)->get();
        return $hoteles;
    }

    // Contar el total de hoteles
    public function contarTotalHoteles()
    {
        // Usamos Eloquent para contar el total de hoteles
        return Hotel::count();
    }

    // Eliminar un hotel
    public function eliminarHotel($id_hotel)
    {
        // Usamos Eloquent para encontrar el hotel y eliminarlo
        $hotel = Hotel::find($id_hotel);
        if ($hotel) {
            $hotel->delete();
            return redirect()->route('admin.hoteles')->with('success', 'Hotel eliminado correctamente.');
        } else {
            return redirect()->route('admin.hoteles')->with('error', '❌ No se encontró el hotel.');
        }
    }
}
