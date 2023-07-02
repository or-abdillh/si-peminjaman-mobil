<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data user yang saat ini sedang login
        $user = Auth::user();

        // cek apakah nomor telepon dan posisi sudah diisi
        if (is_null($user->phone_number) || is_null($user->position)) {
            // beri notifikasi
            notyf()->addError('Profile anda masih kurang lengkap');
            notyf()->addInfo('Silahkan memperbarui profile anda');
        }

        // kirim data ke view
        $data = [
            'page' => 'Profile Pengguna',
        ];

        // render view
        return view('pages.profile.index', $data);
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
        // ambil data pengguna
        $user = User::findOrFail($id);

        // buat rules validasi awal
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'regex:/^(\+62|0)[0-9]{8,15}$/'],
            'position' => ['required', 'string'],
            'email' => []
        ];

        // cek apakah user ingin mengubah email
        if ($user->email !== $request->email) {
            //buat validasi untuk email
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }

        // validasi request yang masuk
        $validate = $request->validate($rules);

        // lakukan update
        $user->update($validate);

        // beri notifikasi
        notyf()->addSuccess('Berhasil memperbaharui informasi akun');

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

    // update password
    public function reset(Request $request)
    {
        // validasi request yang masuk
        $validate = $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // ambil data pengguna yang akan mengubah kata sandi
        $user = User::findOrFail(Auth::user()->id);

        // cek apakah password yang dimasukkan benar
        if (!Hash::check($validate['old_password'], Auth::user()->password)) {
            // beri notifikasi
            notyf()->addErro('Gagal melakukan perubahan kata sandi');
            notyf()->addInfo('Cek kembali form ubah kata sandi anda');

            // kembali ke halaman sebelumnya
            return redirect()->back()->withErrors(['old_password' => 'Incorrect password given']);
        }

        // lakukan perubahan password
        $user->update([
            'password' => bcrypt($validate['password'])
        ]);

        // beri notifikasi
        notyf()->addInfo('Berhasil melakukan perubahan kata sandi');

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }

    // method untuk melakukan perubahan pada profile picture user
    public function changeProfilePicture(Request $request)
    {
        // validasi berkas yang dikirimkan harus PNG, JPG, atau JPEG
        $validate = $request->validate([
            'picture' => 'required|file|mimes:jpeg,jpg,png'
        ]);

        // ambil data user yang sedang login
        $user = User::findOrFail(Auth::user()->id);

        // ambil file
        $file = $request->file('picture');

        // generate nama dokumen
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        // simpan berkas ke storage/app/public/pictures
        $file->storeAs('public/pictures', $filename);

        // cek apakah user sebelumnya pernah mengupload berkas foto
        if (!is_null($user->picture)) {
            // ambil nama file lama
            $oldfile = $user->picture;

            // generate path dari file lama
            $oldpath = 'public/pictures/' . $oldfile;

            // cek apakah berkas masih ada di storage
            if (Storage::exists($oldpath)) {
                // jika ada, hapus file lama
                Storage::delete($oldpath);
            }
        }

        // melakukan perubahan data picture pada user
        $user->update(['picture' => $filename]);

        // berikan notifikasi
        notyf()->addSuccess('Berhasil memperbaharui profile picture');

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
