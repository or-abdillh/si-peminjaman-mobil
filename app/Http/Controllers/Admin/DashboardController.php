<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Kirim data ke view
        $data = [
            'page' => 'Dashboard Administrator',
        ];

        // Notif selamat datang
        notyf()->addInfo('Halo, ' . auth()->user()->name);

        return view('dashboard', $data);
    }
}
