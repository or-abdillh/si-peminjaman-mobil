<?php

namespace App\Http\Controllers\Deputy;

use App\Http\Controllers\Controller;
use App\Models\Validation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // ambil semua pengajuan yang masuk
        $letters = Validation::all()->count();

        // ambil semua pengajuan yang perlu di legalisir oleh deputy
        $validations = Validation::whereNull('deputy_signature')->count();

        // kirim data ke view
        $data = [
            'page' => 'Dashboard Deputi',
            'letters' => $letters,
            'validations' => $validations
        ];

        // render view
        return view('dashboard', $data);
    }
}
