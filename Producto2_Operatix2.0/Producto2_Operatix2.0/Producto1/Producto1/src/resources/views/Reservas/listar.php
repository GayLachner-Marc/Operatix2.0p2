<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function listar()
    {
        $tipo = Session::get('tipo_cliente');
        $email = Session::get('email');

        $reservas = [];

        if ($tipo === 'administrador') {
            $reservas = Reserva::all();
        } elseif ($email) {
            $reservas = Reserva::where('email_cliente', $email)->get();
        }

        return view('reserva.listar', compact('reservas', 'tipo'));
    }
}
