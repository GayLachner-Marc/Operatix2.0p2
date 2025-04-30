<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        $hoteles = Hotel::all();

        return view('admin.hoteles.index', compact('hoteles'));
    }

    public function eliminar(Request $request)
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        $hotel = Hotel::findOrFail($request->get('id'));
        $hotel->delete();

        return redirect()->route('hoteles.index')->with('mensaje', 'Hotel eliminado correctamente.');
    }
}
