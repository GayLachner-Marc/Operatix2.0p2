<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'transfer_vehiculo';

    // La clave primaria de la tabla (opcional si es 'id')
    protected $primaryKey = 'id_vehiculo';

    // Especifica si la tabla tiene marcas de tiempo (created_at, updated_at)
    public $timestamps = false;

    // Atributos que pueden ser asignados en masa
    protected $fillable = [
        'description', 'email_conductor', 'password'
    ];

    // Métodos de acceso (getters)
    public function getIdVehiculo()
    {
        return $this->id_vehiculo;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getEmailConductor()
    {
        return $this->email_conductor;
    }

    public function getPassword()
    {
        return $this->password;
    }

    // Métodos de modificación (setters)
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setEmailConductor($email_conductor)
    {
        $this->email_conductor = $email_conductor;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    // Si necesitas encriptar la contraseña automáticamente antes de guardarla
    public static function boot()
    {
        parent::boot();

        static::creating(function ($vehiculo) {
            if ($vehiculo->password) {
                $vehiculo->password = bcrypt($vehiculo->password); // Hasheamos la contraseña
            }
        });
    }
}
