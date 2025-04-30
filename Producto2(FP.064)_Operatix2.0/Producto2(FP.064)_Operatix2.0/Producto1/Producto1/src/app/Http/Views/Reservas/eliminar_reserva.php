<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function eliminar(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|exists:reservas,id'
        ]);

        if (!Session::has('cliente_id')) {
            return redirect('/cliente/login')->with('error', 'Debes iniciar sesión.');
        }

        $reserva = Reserva::findOrFail($request->id_reserva);

        // Puedes validar si el cliente tiene permiso para eliminarla (si no es admin)
        if (Session::get('tipo_cliente') !== 'administrador' &&
            $reserva->cliente_id !== Session::get('cliente_id')) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar esta reserva.');
        }

        $reserva->delete();

        $redirect = Session::get('tipo_cliente') === 'administrador'
            ? '/admin/home' // o '/admin/reservas'
            : '/reserva/listar';

        return redirect($redirect)->with('success', 'Reserva eliminada correctamente.');
    }
}

