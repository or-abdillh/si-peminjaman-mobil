<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil semua data mobil
        $cars = Car::all();

        // kumpulkan data mobil yang tersedia atau bisa digunakan
        $available = $cars->filter(function ($car) {
            return @$car->status == false;
        });

        // kumpulkan data mobil yang tidak tersedia atau sedang digunakan
        $used = $cars->filter(function ($car) {
            return @$car->status == true;
        });

        // kirim data ke view
        $data = [
            'cars' => $cars,
            'available' => $available,
            'used' => $used,
            'page' => 'Unit Mobil'
        ];

        // render view
        return view('pages.admin.car.index', $data);
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
            'name' => 'required',
            'status' => 'required'
        ]);

        // buat data mobil baru berdasarkan request yang masuk
        $car = Car::create($validate);

        // beri notiikasi berhasil
        notyf()->addSuccess("Berhasil menambahkan $car->name ke dalam database");

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
        // ambil data mobil yang ingin di ubah datanya
        $car = Car::findOrFail($id);

        // validasi request yang masuk
        $validate = $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        // melakukan perubahan data mobil berdasarkan request yang masuk
        $car->update($validate);

        // beri notifikasi berhasil
        notyf()->addSuccess("Berhasil melakukan perubahan data unit $car->name");

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ambil data mobil yang akan dihapus
        $car = Car::findOrFail($id);

        // hapus data mobil dari database
        $car->delete();

        // beri notfikasi berhasil
        notyf()->addSuccess('Berhasil menghapus unit dari database');

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
