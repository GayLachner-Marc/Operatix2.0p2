<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function editar()
    {
        $cliente = Auth::user();
        return view('cliente.editar', compact('cliente'));
    }

    public function actualizar(Request $request)
    {
        $cliente = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cliente->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $cliente->name = $request->nombre;
        $cliente->email = $request->email;

        if ($request->filled('password')) {
            $cliente->password = Hash::make($request->password);
        }

        $cliente->save();

        return redirect()->route('cliente.editar')->with('mensaje', 'Perfil actualizado correctamente.');
    }
}
