<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    //
    public function index()
    {
        // ambil semua surat yang diajukan
        $letters = Letter::withTrashed()->get();

        // ambil semua surat yang disetujui
        $accepteds = Letter::withTrashed()->where('status', true)->count();

        // ambil semua surat yang ditolak
        $rejecteds = Letter::withTrashed()->whereNotNull('status')->where('status', false)->count();

        // ambil semua surat yang masih di proses
        $processes = Letter::whereNull('car_id')->whereNull('status')->count();

        // ambil surat masuk paling terakhir
        $lastLetterSumitted = Letter::withTrashed()->latest()->first();

        // kirim data ke view
        $data = [
            'page' => 'Arsip Surat Pengajuan',
            'letters' => $letters,
            'accepteds' => $accepteds,
            'rejecteds' => $rejecteds,
            'processes' => $processes,
            'lastLetterSubmitted' => $lastLetterSumitted
        ];

        // return response()->json($data);

        // render view
        return view('pages.admin.archive.index', $data);
    }
}
