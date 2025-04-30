<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        // Aquí puedes verificar roles si quieres
        // if (Session::get('tipo_cliente') !== 'administrador') {
        //     return redirect('/cliente/home')->with('error', 'Acceso denegado.');
        // }

        return view('admin.home');
    }
}
