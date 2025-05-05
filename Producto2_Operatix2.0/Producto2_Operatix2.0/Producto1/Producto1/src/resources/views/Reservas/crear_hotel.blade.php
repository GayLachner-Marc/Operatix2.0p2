<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Hotel;
use App\Models\Zona;

class HotelController extends Controller
{
    public function formCrear()
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        $zonas = Zona::all(); // Asume que tienes un modelo Zona

        return view('admin.hoteles.crear', compact('zonas'));
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_zona' => 'required|exists:zonas,id',
            'comision' => 'required|numeric|min:0|max:100',
            'usuario' => 'required|string|max:255|unique:hoteles,usuario',
            'password' => 'required|string|min:6',
        ]);

        try {
            Hotel::create([
                'id_zona' => $request->id_zona,
                'comision' => $request->comision,
                'usuario' => $request->usuario,
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('hoteles.crear.form')->with('mensaje', '✅ Hotel registrado correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', '❌ Error al registrar el hotel.');
        }
    }
}
