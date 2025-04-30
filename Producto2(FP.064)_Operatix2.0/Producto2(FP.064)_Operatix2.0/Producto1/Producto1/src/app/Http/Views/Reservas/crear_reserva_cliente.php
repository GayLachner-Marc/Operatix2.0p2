<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Hotel;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function formCrear()
    {
        if (!Session::has('cliente_id')) {
            return redirect('/cliente/login');
        }

        $tipo_cliente = Session::get('tipo_cliente', 'cliente');
        $volver_url = $tipo_cliente === 'administrador' ? '/admin/home' : '/cliente/home';

        $email = Session::get('email');
        $hoteles = Hotel::all(); // Requiere modelo Hotel

        return view('reserva.crear', compact('volver_url', 'email', 'hoteles'));
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_tipo_reserva' => 'required|in:1,2,3',
            'fecha_entrada' => 'required|date',
            'hora_entrada' => 'required',
            'num_viajeros' => 'required|integer|min:1',
            'id_hotel' => 'required|exists:hoteles,id',
            'numero_vuelo_entrada' => 'required|string',
            'hora_vuelo_salida' => 'nullable',
            'origen_vuelo_entrada' => 'nullable|string',
            'email_cliente' => 'required|email',
        ]);

        Reserva::create([
            'id_tipo_reserva' => $request->id_tipo_reserva,
            'fecha_entrada' => $request->fecha_entrada,
            'hora_entrada' => $request->hora_entrada,
            'num_viajeros' => $request->num_viajeros,
            'id_hotel' => $request->id_hotel,
            'numero_vuelo_entrada' => $request->numero_vuelo_entrada,
            'hora_vuelo_salida' => $request->hora_vuelo_salida,
            'origen_vuelo_entrada' => $request->origen_vuelo_entrada,
            'email_cliente' => $request->email_cliente,
            'id_destino' => 1,
            'fecha_vuelo_salida' => now(),
            'id_vehiculo' => 1,
        ]);

        return redirect()->route('reserva.crear.form')->with('success', 'Reserva creada con éxito');
    }
}
