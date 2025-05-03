<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Hotel;
use App\Models\Zona;

class HotelController extends Controller
{
    public function formEditar($id)
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        $hotel = Hotel::findOrFail($id);
        $zonas = Zona::all();

        return view('admin.hoteles.editar', compact('hotel', 'zonas'));
    }

    public function editar(Request $request)
    {
        $request->validate([
            'id_hotel' => 'required|exists:hoteles,id',
            'id_zona' => 'required|exists:zonas,id',
            'comision' => 'required|numeric|min:0|max:100',
            'usuario' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $hotel = Hotel::findOrFail($request->id_hotel);
        $hotel->id_zona = $request->id_zona;
        $hotel->comision = $request->comision;
        $hotel->usuario = $request->usuario;

        if ($request->filled('password')) {
            $hotel->password = Hash::make($request->password);
        }

        $hotel->save();

        return redirect()->route('hoteles.editar.form', ['id' => $hotel->id])->with('mensaje', 'Hotel actualizado correctamente.');
    }
}
