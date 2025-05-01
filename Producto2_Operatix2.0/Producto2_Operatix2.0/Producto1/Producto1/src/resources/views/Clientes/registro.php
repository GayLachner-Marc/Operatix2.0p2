<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function formRegistro()
    {
        return view('cliente.registro');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'nullable|string|max:255',
            'direccion' => 'required|string|max:255',
            'codigoPostal' => 'required|string|max:10',
            'ciudad' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'password' => 'required|min:6|confirmed',
            'tipo_cliente' => 'required|in:particular,corporativo'
        ]);

        Cliente::create([
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'direccion' => $request->direccion,
            'codigo_postal' => $request->codigoPostal,
            'ciudad' => $request->ciudad,
            'pais' => $request->pais,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_cliente' => $request->tipo_cliente
        ]);

        return redirect()->route('cliente.registro.form')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
