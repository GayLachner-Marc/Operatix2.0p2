<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Vehiculo; // Si necesitas el modelo Vehiculo
use App\Models\Hotel; // Si necesitas el modelo Hotel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ReservaController extends Controller
{
    // Listar todas las reservas
    public function listarReservas()
    {
        $reservas = Reserva::all(); // Usamos Eloquent para obtener todas las reservas
        return view('reservas.listar', compact('reservas'));
    }

    // Crear una nueva reserva
    public function crearReserva(Request $request)
    {
        
        // Validar los datos recibidos
        $request->validate([
            'id_hotel' => 'required|integer',
            'id_tipo_reserva' => 'required|integer',
            'email_cliente' => 'required|email',
            'fecha_entrada' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'num_viajeros' => 'required|integer|min:1',
            'numero_vuelo_entrada' => 'required|string',
            
        ]);

        try {
            // Generar el localizador
            $localizador = strtoupper(bin2hex(random_bytes(4)));

            // Si no se pasa id_destino, lo asignamos como id_hotel por defecto
            $idDestino = $request->id_destino ?? $request->id_hotel;
            $idVehiculo = $request->id_vehiculo ?? null;

            // Crear la reserva usando Eloquent
            $reserva = new Reserva();
            $reserva->localizador = $localizador;
            $reserva->id_hotel = $request->id_hotel;
            $reserva->id_tipo_reserva = $request->id_tipo_reserva;
            $reserva->email_cliente = $request->email_cliente;
            $reserva->fecha_entrada = $request->fecha_entrada;
            $reserva->hora_entrada = $request->hora_entrada;
            $reserva->numero_vuelo_entrada = $request->numero_vuelo_entrada;
            $reserva->origen_vuelo_entrada = $request->origen_vuelo_entrada;
            $reserva->fecha_vuelo_salida = $request->fecha_vuelo_salida;
            $reserva->hora_vuelo_salida = $request->hora_vuelo_salida;
            $reserva->num_viajeros = $request->num_viajeros;
            $reserva->id_destino = $idDestino;
            $reserva->id_vehiculo = $idVehiculo;

            $reserva->save();

            return redirect()->route('reserva.listar')->with('success', 'Reserva creada con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear la reserva: ' . $e->getMessage());
        }
    }

    // Ver detalles de una reserva específica
    public function verReserva($id_reserva)
    {
        $reserva = Reserva::find($id_reserva); // Usamos Eloquent para encontrar la reserva
        if ($reserva) {
            return view('reservas.detalle', compact('reserva'));
        } else {
            return redirect()->route('reserva.listar')->with('error', 'Reserva no encontrada.');
        }
    }

    // Modificar una reserva
    public function modificarReserva(Request $request, $id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (!$reserva) {
            return redirect()->route('reserva.listar')->with('error', 'Reserva no encontrada.');
        }

        $request->validate([
            'fecha_entrada' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'num_viajeros' => 'required|integer|min:1',
        ]);

        $reserva->fecha_entrada = $request->fecha_entrada;
        $reserva->hora_entrada = $request->hora_entrada;
        $reserva->num_viajeros = $request->num_viajeros;

        $reserva->save();

        return redirect()->route('reserva.listar')->with('success', 'Reserva modificada con éxito.');
    }

    // Eliminar una reserva
    public function eliminarReserva($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if ($reserva) {
            $reserva->delete();
            return redirect()->route('reserva.listar')->with('success', 'Reserva eliminada con éxito.');
        } else {
            return redirect()->route('reserva.listar')->with('error', 'Reserva no encontrada.');
        }
    }

    // Obtener reservas por fecha (por rango)
    public function obtenerReservasPorFecha($fecha_inicio, $fecha_fin)
    {
        $reservas = Reserva::whereBetween('fecha_entrada', [$fecha_inicio, $fecha_fin])->get();
        return $reservas;
    }

    // Obtener las últimas reservas
    public function obtenerUltimasReservas($limite = 5)
    {
        $reservas = Reserva::orderBy('id_reserva', 'desc')->take($limite)->get();
        return $reservas;
    }

    // Contar el total de reservas
    public function contarTotalReservas()
    {
        return Reserva::count();
    }

    // Obtener reservas por día
    public function obtenerReservasPorDia($dias = 7)
    {
        $reservas = Reserva::selectRaw('DATE(fecha_reserva) as fecha, COUNT(*) as total')
            ->where('fecha_reserva', '>=', now()->subDays($dias))
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get();
        return $reservas;
    }

    // Obtener la zona más reservada
    public function obtenerZonaMasReservada()
    {
        $zona = DB::table('transfer_reservas')
            ->join('transfer_zona', 'transfer_reservas.id_destino', '=', 'transfer_zona.id_zona')
            ->select('transfer_zona.nombre_zona', DB::raw('count(*) as total'))
            ->groupBy('transfer_zona.nombre_zona')
            ->orderByDesc('total')
            ->limit(1)
            ->first();

        return $zona ?: ['nombre_zona' => 'N/D', 'total' => 0];
    }
   

}
