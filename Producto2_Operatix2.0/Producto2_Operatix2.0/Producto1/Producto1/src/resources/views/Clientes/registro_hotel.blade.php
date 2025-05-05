<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function formularioRegistro()
    {
        return view('hotel.registro');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre_hotel' => 'required|string|max:255',
            'id_zona' => 'required|integer', // ajusta si es string o nombre de zona
            'comision' => 'required|numeric|min:0',
            'email' => 'required|email|unique:hoteles,email',
            'password' => 'required|min:6'
        ]);

        try {
            Hotel::create([
                'nombre' => $request->nombre_hotel,
                'id_zona' => $request->id_zona,
                'comision' => $request->comision,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('hotel.registro.form')->with('success', '✅ Hotel registrado correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', '❌ Ocurrió un error al registrar el hotel.');
        }
    }
}
