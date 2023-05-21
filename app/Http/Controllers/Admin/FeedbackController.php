<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Letter;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // validasi request yang masuk
        $validate = $request->validate([
            'letter_id' => 'required|numeric',
            'body' => 'required'
        ]);

        // ambil data surat berdasarkan letter_id
        $letter = Letter::findOrFail($validate['letter_id']);

        try {
            // ubah status surat menjadi false atau ditolak
            $letter->update(['status' => false]);

            // beri notifikasi
            notyf()->addSuccess('Pengajuan untuk ' . $letter->name . ' berhasil ditolak');

            // buat feedback atau alasan penolakan
            Feedback::create($validate);

            // beri notifikasi
            notyf()->addInfo('Berhasil memberikan alasan penolakan kepada pemohon');
        } catch (QueryException $err) {
            // notyf()->addError($err->getMessage());
            return $err->getMessage();
        }

        // kembali ke halaman sebelumnya
        return redirect()->back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
