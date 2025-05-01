<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    // Método para registrar un cliente
    public function registrarCliente(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'direccion' => 'required|string',
            'codigoPostal' => 'required|string|max:10',
            'ciudad' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'password' => 'required|string|min:8|confirmed',
            'tipo_cliente' => 'required|string'
        ]);

        // Crear nuevo cliente
        Cliente::create([
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2 ?? '', // No obligatorio
            'direccion' => $request->direccion,
            'codigoPostal' => $request->codigoPostal,
            'ciudad' => $request->ciudad,
            'pais' => $request->pais,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_cliente' => $request->tipo_cliente,
        ]);

        return redirect()->route('cliente.login')->with('success', 'Cliente registrado con éxito. ¡Ahora puedes iniciar sesión!');
    }

    // Método para obtener un cliente por su ID
    public function obtenerClientePorId($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }
        return $cliente;
    }

    // Método para modificar el cliente
    public function modificarCliente(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $cliente = Cliente::find($id);
        if (!$cliente) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }

        // Actualizar los campos
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;

        // Si se ha enviado una nueva contraseña, la actualizamos
        if ($request->has('password')) {
            $cliente->password = Hash::make($request->password);
        }

        $cliente->save();

        return redirect()->route('admin.usuarios')->with('success', '✅ Usuario actualizado correctamente.');
    }

    // Método para el login de un cliente
    public function login(Request $request)
    {
        // Validación de las credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $cliente = Cliente::where('email', $request->email)->first();

        if ($cliente && Hash::check($request->password, $cliente->password)) {
            // Autenticamos al cliente
            session(['cliente_id' => $cliente->id, 'cliente_nombre' => $cliente->nombre, 'tipo_cliente' => $cliente->tipo_cliente, 'email' => $cliente->email]);

            // Redirigimos según el tipo de cliente
            return redirect($cliente->tipo_cliente === 'administrador' ? '/admin/home' : '/cliente/home');
        } else {
            return back()->with('error', 'Credenciales incorrectas');
        }
    }

    // Método para obtener todos los clientes
    public function obtenerTodosLosClientes()
    {
        $clientes = Cliente::all();
        return view('Admin.gestionar_usuarios', compact('clientes'));
    }

    // Método para eliminar un cliente
    public function eliminarCliente($id)
    {
        $cliente = Cliente::find($id);
        if ($cliente) {
            $cliente->delete();
            return redirect()->route('admin.usuarios')->with('success', '✅ Cliente eliminado correctamente.');
        } else {
            return redirect()->route('admin.usuarios')->with('error', '❌ No se encontró el cliente.');
        }
    }

    // Método para editar el perfil del cliente
    public function editarPerfil(Request $request)
    {
        $cliente = Cliente::find(session('cliente_id'));
        if (!$cliente) {
            return redirect()->route('cliente.login')->with('error', '❌ Cliente no encontrado.');
        }

        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Actualizar cliente
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;

        // Si hay nueva contraseña, actualizarla
        if ($request->has('password')) {
            $cliente->password = Hash::make($request->password);
        }

        $cliente->save();

        // Actualizamos la sesión
        session(['email' => $cliente->email]);

        return redirect()->route('cliente.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
