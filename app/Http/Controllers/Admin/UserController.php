<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil pengguna berdasarkan jenis role akun
        $users = User::role('user')->get();
        $deputies = User::role('deputy')->get();
        $managers = User::role('manager')->get();

        // Ambil semua jenis role yang ada
        $roles = Role::all();

        // Kirm data ke view
        $data = [
            'page' => 'Pengguna Terdaftar',
            'users' => $users,
            'deputies' => $deputies,
            'managers' => $managers,
            'roles' => $roles
        ];

        // render halaman
        return view('pages.admin.user.index', $data);
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
        // Melakukan validasi request yang masuk
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required']
        ]);

        // Menyimpan request yang masuk ke dalam database
        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password'])
        ]);

        // Menetapkan tipe akun berdasarkan role yang dipilih
        $user->assignRole($validate['role']);

        // Menampilkan notif
        notyf()->addSuccess('Berhasil menambahkan ' . $user->name . ' sebagai ' . $validate['role'] . ' baru');

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
        try {
            // Ambil user yang akan di ubah datanya
            $user = User::findOrfail($id);

            // Jika melakukan perubahan data email pengguna
            if ($user->email == $request->all()['email']) {

                // Melakukan validasi request tanpa perubahan email
                $validate = $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'role' => ['required']
                ]);
            } else {
                // Melakukan validasi request dengan perubahan email
                $validate = $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'role' => ['required']
                ]);
            }

            // Melakukan perubahan data user
            $user->update([
                'name' => $validate['name'],
                'email' => $validate['email']
            ]);

            // Melakukan perubahan tipe akun
            $user->syncRoles([$validate['role']]);
            $user->save();

            // Mengirimkan notif berhasil 
            notyf()->addSuccess('Berhasil melaukan perubahan data pengguna');
        } catch (ValidationException $err) {
            // Kirim notif gagal melakukan pembaruan data pengguna
            notyf()->addError($err->getMessage());
            notyf()->addInfo('Gagal memperbarui data pengguna dari ' . $user->name);
        }

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data usre yang akan di hapus
        $user = User::findOrFail($id);

        // Mengahapus data pengguna
        $user->delete();

        // Kirim kan notifikasi berhasil
        notyf()->addSuccess('Berhasil menghapus data pengguna');

        // Redirect ke halaman sebelumnya
        return redirect()->back();
    }
}
