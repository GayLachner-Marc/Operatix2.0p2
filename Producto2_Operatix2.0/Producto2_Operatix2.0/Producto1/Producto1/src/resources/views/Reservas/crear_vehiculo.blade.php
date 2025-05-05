<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function formCrear()
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        return view('admin.vehiculos.crear');
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_vehiculo' => 'required|unique:vehiculos,id',
            'description' => 'required|string|max:255',
            'email_conductor' => 'required|email|unique:vehiculos,email_conductor',
            'password' => 'required|string|min:6'
        ]);

        Vehiculo::create([
            'id' => $request->id_vehiculo,
            'descripcion' => $request->description,
            'email_conductor' => $request->email_conductor,
            'password_conductor' => Hash::make($request->password)
        ]);

        return redirect()->route('vehiculos.crear.form')->with('mensaje', 'Vehículo añadido correctamente.');
    }
}
