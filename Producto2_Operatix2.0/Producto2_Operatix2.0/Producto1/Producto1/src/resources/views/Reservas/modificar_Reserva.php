<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function formModificar(Request $request)
    {
        $reserva = Reserva::findOrFail($request->query('id'));

        // Verificar permisos: admin o dueño
        if (Session::get('tipo_cliente') !== 'administrador' && Session::get('email') !== $reserva->email_cliente) {
            abort(403, 'No tienes permiso para modificar esta reserva.');
        }

        return view('reserva.modificar', compact('reserva'));
    }

    public function modificar(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|exists:reservas,id',
            'tipo_reserva' => 'required|in:aeropuerto_hotel,hotel_aeropuerto,ida_vuelta',
            'fecha_entrada' => 'required|date',
            'hora_entrada' => 'required',
            'num_viajeros' => 'required|integer|min:1',
            'id_hotel' => 'required|in:1,2,3',
            'numero_vuelo' => 'nullable|string|max:255',
            'hora_vuelo' => 'nullable',
            'origen_vuelo' => 'nullable|string|max:255'
        ]);

        $reserva = Reserva::findOrFail($request->id_reserva);

        // Permisos
        if (Session::get('tipo_cliente') !== 'administrador' && Session::get('email') !== $reserva->email_cliente) {
            abort(403);
        }

        $reserva->update([
            'tipo_reserva' => $request->tipo_reserva,
            'fecha_entrada' => $request->fecha_entrada,
            'hora_entrada' => $request->hora_entrada,
            'num_viajeros' => $request->num_viajeros,
            'id_hotel' => $request->id_hotel,
            'numero_vuelo_entrada' => $request->numero_vuelo,
            'hora_vuelo_salida' => $request->hora_vuelo,
            'origen_vuelo_entrada' => $request->origen_vuelo,
        ]);

        return redirect()->route('reserva.listar')->with('success', 'Reserva modificada correctamente.');
    }
}
