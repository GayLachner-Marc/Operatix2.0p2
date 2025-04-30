<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos (opcional si sigue la convención plural)
    protected $table = 'tranfer_hotel';

    // La clave primaria de la tabla (opcional si es 'id')
    protected $primaryKey = 'id_hotel';

    // Especifica si los campos de la tabla usan marcas de tiempo (created_at, updated_at)
    public $timestamps = false;

    // Define los atributos que son asignables en masa (por ejemplo, al realizar un create o update)
    protected $fillable = [
        'id_zona', 'comision', 'usuario', 'password'
    ];

    // Si quieres asegurarte de que la contraseña se encripte al guardarla
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hotel) {
            if ($hotel->password) {
                $hotel->password = bcrypt($hotel->password); // Usamos bcrypt para hashear la contraseña
            }
        });
    }

    // Métodos de acceso (getters), si realmente los necesitas
    public function getIdHotel()
    {
        return $this->id_hotel;
    }

    public function getIdZona()
    {
        return $this->id_zona;
    }

    public function getComision()
    {
        return $this->comision;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getPassword()
    {
        return $this->password;
    }

    // Métodos de modificación (setters)
    public function setIdZona($id_zona)
    {
        $this->id_zona = $id_zona;
    }

    public function setComision($comision)
    {
        $this->comision = $comision;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
