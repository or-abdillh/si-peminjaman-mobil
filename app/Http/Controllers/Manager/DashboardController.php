<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ambil data manager yang sedang login saat ini
        $manager = User::findOrFail(auth()->user()->id);

        // ambil semua bawahan
        $employees = $manager->employees->count(0);

        // ambil semua pengajuan yang di ajukan oleh bawahan yang sudah di konfirmasi oleh admin
        $letters = Letter::whereNotNull('car_id')
            ->whereIn('user_id', function ($query) use ($manager) {
                $query->select('user_id')
                    ->from('user_managers')
                    ->where('manager_id', $manager->id);
            })->count();

        // Kirim data ke view
        $data = [
            'page' => 'Dashboard Atasan',
            'employees' => $employees,
            'letters' => $letters
        ];

        // return $data;

        // Notif selamat datang
        notyf()->addInfo('Halo, ' . auth()->user()->name);

        return view('dashboard', $data);
    }
}
