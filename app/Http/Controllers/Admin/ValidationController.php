<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Validation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil semua legalisir
        $validations = Validation::all();

        // ambil legalisir yang masuk hari ini
        $validationTodays = Validation::whereDate('created_at', Carbon::now())->get();

        // ambil legalisir yang belum di setujui
        $validationProcesses = $validations->map(function ($validation) {
            return Letter::where('id', $validation->letter_id)->whereNull('status')->first();
        })->filter();

        // beri notifikasi
        if (count($validationProcesses) > 0) notyf()->addInfo('Ada ' . count($validationProcesses) . ' pengajuan yang perlu di setujui');
        else notyf()->addSuccess('Tidak ada pengajuan yang perlu disetujui');

        // kirim data ke view
        $data = [
            'page' => 'Legalisir Pengajuan',
            'validations' => $validations,
            'validationTodays' => $validationTodays,
            'validationProcesses' => $validationProcesses
        ];

        // return response()->json($data);

        // render view
        return view('pages.admin.validation.index', $data);
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
        // ambil data pengajuan
        $letter = Letter::findOrFail($id);

        // ambil detail legalisir berdasarkan pengajuan
        $validation = $letter->validation;

        // cek apakah semua ttd sudah terisi
        if (
            is_null($validation->applicant_signature)
            || is_null($validation->manager_signature)
            || is_null($validation->deputy_signature)
        ) {
            // beri notifikasi
            notyf()->addInfo('Kolom legalisir masih ada yang kosong');
            notyf()->addError('Proses diabatalkan');

            // kembali ke halaman sebelumnya
            return redirect()->back();
        }

        // ubah status pengajuan menjadi true
        $letter->update(['status' => true]);

        // beri notifikasi
        notyf()->addSuccess('Berhasil menyetujui legalisir pengajuan peminjaman');

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
