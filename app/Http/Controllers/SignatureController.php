<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil data signature berdasarkan user yang login
        $signature = Signature::where('user_id', Auth::user()->id)->first();

        if ($signature) {
            // ambil surat pengajuan yang menggunakan tanda tangan ini
            $usedByLetter = $signature->validationsAsApplicant->count();

            // membuat route untuk form signature edit atau create
            $route = route('signature.update', $signature->id);
        } else {
            $route = route('signature.store');
            $usedByLetter = 0;
        }

        // Kirim data ke view
        $data = [
            'page' => 'Tanda Tangan Digital',
            'signature' => $signature,
            'route' => $route,
            'usedByLetter' => $usedByLetter
        ];

        return view('pages.signature.index', $data);
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
        // melakukan validasi pada request yang masuk
        $validate = $request->validate([
            'image' => 'required'
        ]);

        // Upload tanda tangan ke storage
        $fileName = $this->siganatureUploadToStorage($validate['image']);

        // simpan informasi filename ke dalam database
        Signature::create([
            'user_id' => Auth::user()->id,
            'image' => $fileName
        ]);

        // kirim notifikasi berhasil
        notyf()->addSuccess('Berhasil membuat tanda tangan baru untuk ' . Auth::user()->name);

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
        // mengambil data signature yang ingin di ubah
        $signature = Signature::findOrFail($id);

        // validate request yang masuk
        $validate = $request->validate([
            'image' => 'required'
        ]);

        // membuat file path penuh file sebelumnya
        $oldFilePath = 'public/signatures/' . $signature->image;

        // cek apakah file tersebut masih ada di dalam storage
        if (Storage::exists($oldFilePath)) {
            // hapus file lama
            Storage::delete($oldFilePath);

            // berikan notifikasi berhasil di hapus
            notyf()->addInfo('Tanda tangan yang lama berhasil dihapus');
        }

        // melakukan upload ulang tanda tangan baru
        $fileName = $this->siganatureUploadToStorage($validate['image']);

        // update data siganature dengan yang baru
        $signature->update(['image' => $fileName]);

        // berikan notifikasi berhasil melakukan perubahan
        notyf()->addSuccess('Berhasil meperbaharui tanda tangan milik ' . Auth::user()->name);

        // kembali ke halamaan sebelumnya
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ambil data signature yang ingin dihapus
        $signature = Signature::findOrFail($id);

        // buat full path dari file signature yang ada di storage
        $filePath = 'public/signatures/' . $signature->image;

        // cek apakah file tersebut ada
        if (Storage::exists($filePath)) {
            // hapus dari storage
            Storage::delete($filePath);

            // berikan notifikasi berhasil di hapus
            notyf()->addInfo('Berhasil menghapus file tanda tangan dari storage');
        }

        // hapus data
        $signature->delete();

        // berikan notifikasi berhasil
        notyf()->addSuccess('Berhasil mengahapus tanda tangan digital milik ' . Auth::user()->name);
        notyf()->addInfo('Silahkan melakukan perekaman lagi jika diperlukan');

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }

    // method untuk melakukan proses upload request dari base64 dan return berupa filename
    public function siganatureUploadToStorage($signature)
    {
        // Pisahkan header base64 dari data gambar
        $imageInfo = explode(";base64,", $signature);

        // Ambil ekstensi gambar dari header
        $imageExtension = explode('/', $imageInfo[0])[1];

        // Ambil ekstensi gambar dari header
        $decodedImage = base64_decode($imageInfo[1]);

        // generate nama unik untuk file image
        $fileName = uniqid() . '.' . $imageExtension;

        // membuat path dari file ke dalam storage folder
        $storagePath = storage_path('app/public/signatures/' . $fileName);

        // memasukkan file ke dalam storage
        file_put_contents($storagePath, $decodedImage);

        return $fileName;
    }
}
