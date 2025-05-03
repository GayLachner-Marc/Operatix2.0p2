<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function formEditar($id)
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        $vehiculo = Vehiculo::findOrFail($id);
        return view('admin.vehiculos.editar', compact('vehiculo'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'description' => 'required|string|max:255',
            'email_conductor' => 'required|email',
            'password' => 'nullable|string|min:6',
        ]);

        $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);
        $vehiculo->descripcion = $request->description;
        $vehiculo->email_conductor = $request->email_conductor;

        if ($request->filled('password')) {
            $vehiculo->password_conductor = Hash::make($request->password);
        }

        $vehiculo->save();

        return redirect()->route('vehiculos.editar.form', ['id' => $vehiculo->id])
                         ->with('mensaje', 'Vehículo actualizado correctamente.');
    }
}
