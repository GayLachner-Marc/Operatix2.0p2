<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function editar($id)
    {
        $usuario = Usuario::findOrFail($id); // Requiere modelo Usuario

        return view('admin.usuarios.editar', [
            'usuario' => $usuario,
            'mensaje' => Session::get('mensaje'),
            'error' => Session::get('error')
        ]);
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $usuario = Usuario::findOrFail($request->id);
            $usuario->nombre = $request->nombre;
            $usuario->email = $request->correo;

            if ($request->filled('password')) {
                $usuario->password = bcrypt($request->password);
            }

            $usuario->save();
            return redirect()->route('usuarios.editar', ['id' => $usuario->id])->with('mensaje', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el usuario.');
        }
    }
}
