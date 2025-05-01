<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class HotelPanelController extends Controller
{
    public function home()
    {
        if (Session::get('tipo_cliente') !== 'hotel') {
            return redirect('/cliente/login');
        }

        return view('hotel.panel');
    }
}
