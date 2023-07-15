<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Letter;

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

        // ambil semua pengajuan
        $letters = letter::all();

        return view('dashboard', $data);
    }
}
