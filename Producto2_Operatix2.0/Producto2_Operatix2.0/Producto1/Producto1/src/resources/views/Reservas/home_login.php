<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'tipo_usuario' => 'required|in:cliente,hotel,admin'
        ]);

        // Aquí iría tu lógica real de autenticación personalizada
        // Simulación de login para demostración:
        if ($request->email === 'admin@example.com' && $request->password === '1234' && $request->tipo_usuario === 'admin') {
            Session::put('cliente_id', 1);
            Session::put('tipo_cliente', 'administrador');
            return redirect('/admin/home');
        }

        return back()->withInput()->with('error', 'Credenciales inválidas o tipo de usuario incorrecto.');
    }
}
