<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VehiculoController extends Controller
{
    // Método para listar todos los vehículos
    public function listarVehiculos()
    {
        $vehiculos = Vehiculo::all(); // Usamos Eloquent para obtener todos los vehículos
        return view('vehiculos.listar', compact('vehiculos'));
    }

    // Método para ver los detalles de un vehículo específico
    public function verVehiculo($id_vehiculo)
    {
        $vehiculo = Vehiculo::find($id_vehiculo); // Buscamos el vehículo por ID
        if ($vehiculo) {
            return view('vehiculos.detalle', compact('vehiculo'));
        } else {
            return redirect()->route('vehiculo.listar')->with('error', 'Vehículo no encontrado.');
        }
    }

    // Método para registrar un nuevo vehículo (admin)
    public function crearVehiculo(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'email_conductor' => 'required|email',
            'password' => 'required|min:6',
        ]);

        try {
            // Crear un nuevo vehículo usando Eloquent
            $vehiculo = new Vehiculo();
            $vehiculo->description = $request->description;
            $vehiculo->email_conductor = $request->email_conductor;
            $vehiculo->password = bcrypt($request->password); // Usamos bcrypt para encriptar la contraseña
            $vehiculo->save();

            return redirect()->route('vehiculo.listar')->with('success', 'Vehículo registrado con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar el vehículo: ' . $e->getMessage());
        }
    }

    // Método para actualizar un vehículo
    public function actualizarVehiculo(Request $request, $id_vehiculo)
    {
        $vehiculo = Vehiculo::find($id_vehiculo);
        
        if (!$vehiculo) {
            return redirect()->route('vehiculo.listar')->with('error', 'Vehículo no encontrado.');
        }

        $request->validate([
            'description' => 'required|string',
            'email_conductor' => 'required|email',
            'password' => 'nullable|min:6', // No es obligatorio actualizar la contraseña
        ]);

        try {
            // Actualizar los campos del vehículo
            $vehiculo->description = $request->description;
            $vehiculo->email_conductor = $request->email_conductor;

            // Si la contraseña es proporcionada, la actualizamos
            if ($request->filled('password')) {
                $vehiculo->password = bcrypt($request->password);
            }

            $vehiculo->save();

            return redirect()->route('vehiculo.listar')->with('success', 'Vehículo actualizado con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el vehículo: ' . $e->getMessage());
        }
    }

    // Método para eliminar un vehículo
    public function eliminarVehiculo($id_vehiculo)
    {
        $vehiculo = Vehiculo::find($id_vehiculo);

        if ($vehiculo) {
            $vehiculo->delete();
            return redirect()->route('vehiculo.listar')->with('success', 'Vehículo eliminado con éxito.');
        } else {
            return redirect()->route('vehiculo.listar')->with('error', 'Vehículo no encontrado.');
        }
    }
}
