<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function mostrarCalendario(Request $request)
    {
        $reservas = [];

        if ($request->filled(['fecha_inicio', 'fecha_fin'])) {
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            $reservas = Reserva::whereBetween('fecha_entrada', [$fecha_inicio, $fecha_fin])->get();
        }

        return view('calendario.reservas', compact('reservas'));
    }
}
