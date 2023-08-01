<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // ambil user yang sedang logi
        $user = Auth::user();

        // hitung semua surat yang pernah diajukan
        $letters = Letter::withTrashed()->where('user_id', $user->id)->count();

        // Ambil semua surat yang pernah dibuat dan di telah disetujui
        $letterAccepteds = Letter::withTrashed()->where('user_id', $user->id)->where('status', true)->count();

        // Ambil semua surat yang pernah dibuat tapi ditolak
        $letterRejecteds = Letter::withTrashed()->where('user_id', $user->id)->where('status', false)->count();

        // Kirim data ke view
        $data = [
            'page' => 'Dashboard Pengguna',
            'letters' => $letters,
            'letterAccepteds' => $letterAccepteds,
            'letterRejecteds' => $letterRejecteds
        ];

        // return $data;

        // Notif selamat datang
        notyf()->addInfo('Halo, ' . auth()->user()->name);

        return view('dashboard', $data);
    }
}
