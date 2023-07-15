<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    //
    public function index()
    {

        // Ambil semua surat
        $letters = Letter::all()->count();

        // ambil semua surat yang disetujui
        $letterAccepteds = Letter::withTrashed()->where('status', true)->count();

        // ambil semua unit mobil
        $cars = Car::all()->count();

        // ambil semua pengguna yang bukan admin
        $users = User::role(['user', 'deputy', 'manager'])->count();    

        // Kirim data ke view
        $data = [
            'page' => 'Dashboard Administrator',
            'letters' => $letters,
            'letterAccepteds' => $letterAccepteds,
            'cars' => $cars,
            'users' => $users
        ];

        // Notif selamat datang
        notyf()->addInfo('Halo, ' . auth()->user()->name);

        return view('dashboard', $data);
    }
}
