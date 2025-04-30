<?php

use Illuminate\Support\Facades\Session;
use App\Models\Usuario;

public function index()
{
    $clientes = Usuario::all(); // Puedes aplicar filtros si deseas solo clientes

    $tipo_cliente = Session::get('tipo_cliente', 'cliente');
    $panelURL = $tipo_cliente === 'administrador' ? '/admin/home' : '/cliente/home';

    return view('admin.usuarios.index', [
        'clientes' => $clientes,
        'panelURL' => $panelURL,
        'mensaje' => Session::get('mensaje'),
        'error' => Session::get('error'),
    ]);
}
