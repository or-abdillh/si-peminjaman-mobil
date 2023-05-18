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
        //
        $cars = Car::all();
        
        $available = $cars->filter(function($car) {
            return @$car->status == false;
        });

        $used = $cars->filter(function($car) {
            return @$car->status == true;
        });

        $data = [
            'cars' => $cars,
            'available' => $available,
            'used' => $used,
            'page' => 'Unit Mobil'
        ];

        return view('pages.admin.car.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pages.admin.car.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validate = $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $car = Car::create($validate);
        notyf()->addSuccess("Berhasil menambahkan $car->name ke dalam database");

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
        $car = Car::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $car->update($validate);

        notyf()->addSuccess("Berhasil melakukan perubahan data unit $car->name");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $car = Car::findOrFail($id);

        $car->delete();
        notyf()->addSuccess('Berhasil menghapus unit dari database');
        return redirect()->back();
    }
}
