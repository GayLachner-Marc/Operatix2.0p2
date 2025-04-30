<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClienteRepository
{
    // Obtenemos un cliente por ID utilizando Eloquent
    public function obtenerPorId($id)
    {
        return DB::table('transfer_viajeros')->where('id_viajero', $id)->first();
    }

    // Actualizamos los datos de un cliente
    public function actualizar($id, $nombre, $email, $password = null)
    {
        // Si se pasa una contraseña nueva, la actualizamos
        if ($password) {
            $passwordHashed = bcrypt($password); // Usamos bcrypt para hashear la contraseña
            return DB::table('transfer_viajeros')
                ->where('id_viajero', $id)
                ->update([
                    'nombre' => $nombre,
                    'email' => $email,
                    'password' => $passwordHashed
                ]);
        } else {
            return DB::table('transfer_viajeros')
                ->where('id_viajero', $id)
                ->update([
                    'nombre' => $nombre,
                    'email' => $email
                ]);
        }
    }
}
