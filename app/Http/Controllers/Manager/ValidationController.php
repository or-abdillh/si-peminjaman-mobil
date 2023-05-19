<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Signature;
use App\Models\User;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil data manager yang saat ini sedang login
        $user = User::findOrFail(Auth::user()->id);

        // ambil semua pengajuan yang di ajukan oleh bawahan yang sudah di konfirmasi oleh admin
        $letters = Letter::whereNotNull('car_id')
            ->whereIn('user_id', function ($query) use ($user) {
                $query->select('user_id')
                    ->from('user_managers')
                    ->where('manager_id', $user->id);
            })->get();

        // ambil semua pengajuan yang perlu di legalisir oleh manager atau deputy
        $validations = $letters->map(function ($letter) {
            return Validation::where('letter_id', $letter->id)
                ->whereNull('manager_signature')
                ->first();
        })->filter();

        // beri notifikasi
        if (count($validations) > 0) notyf()->addInfo('Ada ' . count($validations) . ' pengajuan yang perlu dilegalisir');
        else notyf()->addSuccess('Tidak ada pengajuan yang perlu dilegalisir');

        // cek apakah manager memiliki tanda tangan digital
        $signature = $user->signature;

        if (!$signature) {
            // beri notifikasi jika belum ada tanda tangan
            notyf()->addError('Anda belum memiliki tanda tangan digital');
            notyf()->addInfo('Silahkan untuk melakukan perekaman terlebih dahulu');
        }

        // kirim data ke view
        $data = [
            'page' => 'Legalisir Pengajuan',
            'letters' => count($letters),
            'validations' => $validations,
        ];

        // render view
        return view('pages.manager.validation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ambil data pengajuan yang akan di legalisir oleh manager
        $validation = Validation::findOrFail($id);

        // ambil tanda tangan manager
        $signature = Signature::where('user_id', Auth::user()->id)->first();

        // jika tanda tangan tidak ditemukan
        if (!$signature) {
            notyf()->addError('Anda belum memiliki tanda tangan digital');
            notyf()->addInfo('Silahkan untuk melakukan perekaman terlebih dahulu');
            notyf()->addInfo('Proses dibatalkan');

            // kembali ke halaman sebelumnya
            return redirect()->back();
        }

        // cek apakah file tanda tangan ada di storage
        $signaturePath = 'public/signatures/' . $signature->image;

        if (!Storage::exists($signaturePath)) {
            // beri notifikasi
            notyf()->addError('File tanda tangan tidak ditemukan pada storage');
            notyf()->addInfo('Silahkan untuk melakukan perekaman ulang, atau hubungi admin');
            notyf()->addInfo('Proses dibatalkan');

            // kembali ke halaman sebelumnya
            return redirect()->back();
        }

        // melakukan update pada data legalisir
        $validation->update(['manager_signature' => $signature->id]);

        // beri notifikasi
        notyf()->addSuccess('Proses legalisir berhasil');

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
