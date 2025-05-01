<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservaController extends Controller
{
    public function crear()
    {
        if (!Session::has('cliente_id')) {
            return redirect('/cliente/login');
        }

        $tipo_cliente = Session::get('tipo_cliente', 'cliente');
        $volver_url = $tipo_cliente === 'administrador' ? '/admin/home' : '/cliente/home';

        $email = Session::get('email');

        return view('reserva.crear', compact('volver_url', 'email'));
    }

    public function guardar(Request $request)
    {
        // Validar y guardar reserva (por implementar)
        return back()->with('success', 'Reserva creada correctamente.');
    }
}
