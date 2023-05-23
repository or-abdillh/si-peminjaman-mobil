<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserManager;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil data manager yang sedang login saat ini
        $manager = User::findOrFail(auth()->user()->id);

        // ambil semua bawahan
        $employees = $manager->employees;

        // ambil semua karyawan yang bukan bawahan
        $otherEmployees = User::role('user')
            ->whereNotIn('id', function ($query) use ($manager) {
                $query->select('user_id')
                    ->from('user_managers')
                    ->where('manager_id', $manager->id);
            })->get();

        // kirim data ke view
        $data = [
            'page' => 'Karyawan Dibawah Anda',
            'employees' => $employees,
            'otherEmployees' => $otherEmployees
        ];

        // return response()->json($employees[0]->employeeDetail->name);

        // render view
        return view('pages.manager.employee.index', $data);
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
            'user_id' => 'required|integer',
            'manager_id' => 'required|integer'
        ]);

        // membuat data karyawan baru
        $employee = UserManager::create($validate);

        // buat notifikasi berhasil menambahkan bawahan baru
        notyf()->addSuccess('Berhasil menambahkan ' . $employee->employeeDetail->name . ' sebagai bawahan anda');

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
        // ambil data bawahan yang akan di hapus
        $employee = UserManager::findOrFail($id);
        $employeeName = $employee->employeeDetail->name;

        // hapus data bawahan
        $employee->delete();

        // berikan notifikasi berhasil
        notyf()->addSuccess('Berhasil menghapus ' . $employeeName . ' sebagai bawahan anda');

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
