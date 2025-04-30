<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservaController extends Controller
{
    public function formConfirmar(Request $request)
    {
        if (!Session::has('cliente_id')) {
            return redirect('/cliente/login');
        }

        $tipo_cliente = Session::get('tipo_cliente', 'cliente');
        $volver_url = $tipo_cliente === 'administrador' ? '/admin/home' : '/cliente/home';

        // Simular que los datos vienen de un paso anterior (ej: request()->all() o session())
        return view('reserva.confirmar', array_merge(
            $request->all(),
            ['volver_url' => $volver_url]
        ));
    }

    public function confirmar(Request $request)
    {
        // Aquí procesas la creación final de la reserva
        // Por ejemplo: Reserva::create([...]);

        return redirect()->route('reserva.confirmar.form')->with('success', 'Reserva confirmada correctamente.');
    }
}
