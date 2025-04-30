<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    public function home()
    {
        if (Session::get('tipo_cliente') === 'administrador') {
            return redirect('/admin/home');
        }

        return view('cliente.home');
    }
}
