<?php

namespace App\Http\Controllers\Deputy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // kirim data ke view
        $data = [
            'page' => 'Dashboard Deputi'
        ];

        // Notif selamat datang
        notyf()->addInfo('Halo, ' . auth()->user()->name);
        
        // render view
        return view('dashboard', $data);
    }
}
