<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        // Verificación de acceso
        if (Session::get('tipo_cliente') !== 'administrador') {
            return redirect('/cliente/login');
        }

        // Ejemplos de consultas simuladas
        $totalReservas = DB::table('reservas')->count();
        $totalHoteles = DB::table('hoteles')->count();

        $zonaMasReservada = DB::table('reservas')
            ->select('zonas.nombre_zona', DB::raw('count(*) as total'))
            ->join('hoteles', 'reservas.id_hotel', '=', 'hoteles.id_hotel')
            ->join('zonas', 'hoteles.id_zona', '=', 'zonas.id_zona')
            ->groupBy('zonas.nombre_zona')
            ->orderByDesc('total')
            ->first();

        $ultimasReservas = DB::table('reservas')
            ->orderByDesc('fecha_reserva')
            ->take(10)
            ->get();

        $ultimosHoteles = DB::table('hoteles')
            ->join('zonas', 'hoteles.id_zona', '=', 'zonas.id_zona')
            ->orderByDesc('hoteles.created_at')
            ->take(10)
            ->get();

        $reservasPorDia = DB::table('reservas')
            ->select(DB::raw('DATE(fecha_reserva) as fecha'), DB::raw('COUNT(*) as total'))
            ->where('fecha_reserva', '>=', now()->subDays(7))
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('admin.reportes.index', compact(
            'totalReservas',
            'totalHoteles',
            'zonaMasReservada',
            'ultimasReservas',
            'ultimosHoteles',
            'reservasPorDia'
        ));
    }
}
