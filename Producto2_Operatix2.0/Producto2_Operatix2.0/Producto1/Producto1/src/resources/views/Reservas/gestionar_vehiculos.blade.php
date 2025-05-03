<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function index()
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        $vehiculos = Vehiculo::all();

        return view('admin.vehiculos.index', compact('vehiculos'));
    }

    public function eliminar(Request $request)
    {
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        $vehiculo = Vehiculo::findOrFail($request->get('id'));
        $vehiculo->delete();

        return redirect()->route('vehiculos.index')->with('mensaje', 'Vehículo eliminado correctamente.');
    }
}
