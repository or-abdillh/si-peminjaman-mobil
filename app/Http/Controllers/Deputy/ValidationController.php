<?php

namespace App\Http\Controllers\Deputy;

use App\Http\Controllers\Controller;
use App\Models\Signature;
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
        // ambil semua pengajuan yang masuk
        $letters = Validation::all()->count();

        // ambil semua pengajuan yang perlu di legalisir oleh deputy
        $validations = Validation::whereNull('deputy_signature')->get();

        // jika ada yang perlu dilegalisir
        if (count($validations) > 0) notyf()->addInfo('Ada ' . count($validations) . ' pengajuan yang perlu anda legalisir');
        else notyf()->addSuccess('Tidak ada pengajuan yang perlu anda legalisir');

        // kirim data ke view
        $data = [
            'page' => 'Legalisir Pengajuan',
            'letters' => $letters,
            'validations' => $validations
        ];

        // render view
        return view('pages.deputy.validation.index', $data);
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
        $validation->update(['deputy_signature' => $signature->id]);

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
