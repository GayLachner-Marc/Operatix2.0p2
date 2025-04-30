<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Asegúrate de tener este modelo en Laravel

class AdminController extends Controller
{
    // Método para editar el usuario
    public function editarUsuario($id)
    {
        // Buscar al usuario por su ID
        $usuario = Cliente::find($id);

        if (!$usuario) {
            // Si no se encuentra el usuario, redirigimos con un mensaje de error
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }

        // Si encontramos el usuario, cargamos la vista para editar
        return view('Admin.editar_usuario', compact('usuario'));
    }

    // Método para actualizar el usuario
    public function actualizarUsuario(Request $request, $id)
    {
        // Validación de datos
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',  // Confirmación de la contraseña
        ]);

        // Buscar al usuario
        $usuario = Cliente::find($id);

        if (!$usuario) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }

        // Actualizamos los datos del usuario
        $usuario->update($data);

        // Si la contraseña es nueva, la encriptamos
        if ($request->has('password')) {
            $usuario->password = bcrypt($request->input('password'));
            $usuario->save();
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.usuarios')->with('mensaje', '✅ Usuario actualizado correctamente.');
    }
}
