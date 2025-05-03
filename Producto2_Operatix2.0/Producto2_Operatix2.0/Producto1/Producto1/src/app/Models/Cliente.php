<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    
    // Definir la tabla asociada al modelo
    protected $table = 'transfer_viajeros';

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = [
        'nombre', 'apellido1', 'apellido2', 'direccion', 'codigoPostal', 'ciudad', 'pais', 'email', 'password', 'tipo_cliente'
    ];

    // No necesitas especificar 'id' ya que Laravel lo maneja por defecto
    protected $primaryKey = 'id_viajero'; 

    // Desactivar los timestamps si no los estás usando
    public $timestamps = false;

    // Métodos de acceso (getters) si los necesitas
    public function getId()
    {
        return $this->id_viajero;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    // Si necesitas encriptar la contraseña automáticamente antes de guardarla
    public static function boot()
    {
        parent::boot();

        static::creating(function ($cliente) {
            $cliente->password = bcrypt($cliente->password);
        });
    }
}
