<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function mostrarCalendario()
    {
        $volverUrl = '/cliente/home';
        if (Session::get('tipo_cliente') === 'administrador') {
            $volverUrl = '/admin/home';
        }

        $reservasPorDia = [
            '2025-04-01' => 1,
            '2025-04-05' => 2,
            '2025-04-10' => 3,
            '2025-04-15' => 1,
            '2025-04-20' => 2,
            '2025-04-22' => 1,
            '2025-04-30' => 2,
        ];

        $year = 2025;
        $month = 4;
        $daysInMonth = date('t', strtotime("$year-$month-01"));
        $firstDayOfWeek = date('N', strtotime("$year-$month-01"));

        return view('calendario', compact(
            'volverUrl',
            'reservasPorDia',
            'year',
            'month',
            'daysInMonth',
            'firstDayOfWeek'
        ));
    }
}
