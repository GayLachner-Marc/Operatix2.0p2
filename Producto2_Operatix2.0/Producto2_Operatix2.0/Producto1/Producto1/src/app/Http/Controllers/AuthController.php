<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('Clientes.login');
    }

    // Maneja el inicio de sesión
    public function login(Request $request)
    {
        // Validación de datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Intentar autenticar
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirigir si el login es exitoso
            return redirect()->route('home');
        }

        // Redirigir al formulario de login con un error
        return back()->withErrors(['login_error' => 'Credenciales incorrectas']);
    }

    // Cierra la sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
