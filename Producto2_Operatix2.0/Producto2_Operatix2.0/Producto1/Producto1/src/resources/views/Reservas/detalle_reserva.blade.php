<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function detalle($id)
    {
        $reserva = Reserva::findOrFail($id);

        $is_admin = Session::get('tipo_cliente') === 'administrador';
        $volver_url = $is_admin ? '/admin/home' : '/cliente/home';

        return view('reserva.detalle', [
            'reserva' => $reserva,
            'is_admin' => $is_admin,
            'volver_url' => $volver_url
        ]);
    }
}
