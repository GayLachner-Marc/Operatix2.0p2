<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Redirección si ya está logueado
        $tipo = Session::get('tipo_cliente');
        if ($tipo === 'administrador') {
            return redirect('/admin/home');
        } elseif ($tipo === 'corporativo' || $tipo === 'cliente') {
            return redirect('/cliente/home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Aquí iría la lógica real de autenticación (ejemplo simplificado):
        $correo = $request->input('correo');
        $password = $request->input('password');

        // Simular autenticación exitosa
        if ($correo === 'admin@ejemplo.com' && $password === 'admin') {
            Session::put('tipo_cliente', 'administrador');
            Session::put('email', $correo);
            return redirect('/admin/home');
        }

        if ($correo === 'cliente@ejemplo.com' && $password === 'cliente') {
            Session::put('tipo_cliente', 'cliente');
            Session::put('email', $correo);
            return redirect('/cliente/home');
        }

        return redirect()->route('login')->with('error', 'Credenciales inválidas.');
    }
}
