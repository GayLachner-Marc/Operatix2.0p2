<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'transfer_reservas';

    // La clave primaria de la tabla (opcional si es 'id')
    protected $primaryKey = 'id_reserva';

    // Especifica si la tabla tiene marcas de tiempo (created_at, updated_at)
    public $timestamps = false;

    // Atributos que pueden ser asignados en masa
    protected $fillable = [
        'localizador', 'id_hotel', 'id_tipo_reserva', 'email_cliente', 'fecha_reserva', 'fecha_modificacion',
        'id_destino', 'fecha_entrada', 'hora_entrada', 'numero_vuelo_entrada', 'origen_vuelo_entrada',
        'hora_vuelo_salida', 'fecha_vuelo_salida', 'num_viajeros', 'id_vehiculo'
    ];

    // Definir los métodos de acceso (getters)
    public function getIdReserva()
    {
        return $this->id_reserva;
    }

    public function getLocalizador()
    {
        return $this->localizador;
    }

    public function getIdHotel()
    {
        return $this->id_hotel;
    }

    public function getIdTipoReserva()
    {
        return $this->id_tipo_reserva;
    }

    public function getEmailCliente()
    {
        return $this->email_cliente;
    }

    public function getFechaReserva()
    {
        return $this->fecha_reserva;
    }

    public function getFechaModificacion()
    {
        return $this->fecha_modificacion;
    }

    public function getIdDestino()
    {
        return $this->id_destino;
    }

    public function getFechaEntrada()
    {
        return $this->fecha_entrada;
    }

    public function getHoraEntrada()
    {
        return $this->hora_entrada;
    }

    public function getNumeroVueloEntrada()
    {
        return $this->numero_vuelo_entrada;
    }

    public function getOrigenVueloEntrada()
    {
        return $this->origen_vuelo_entrada;
    }

    public function getHoraVueloSalida()
    {
        return $this->hora_vuelo_salida;
    }

    public function getFechaVueloSalida()
    {
        return $this->fecha_vuelo_salida;
    }

    public function getNumViajeros()
    {
        return $this->num_viajeros;
    }

    public function getIdVehiculo()
    {
        return $this->id_vehiculo;
    }

    // Métodos de modificación (setters)
    public function setNumViajeros($num_viajeros)
    {
        $this->num_viajeros = $num_viajeros;
    }

    public function setFechaModificacion($fecha_modificacion)
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function setIdVehiculo($id_vehiculo)
    {
        $this->id_vehiculo = $id_vehiculo;
    }
}
