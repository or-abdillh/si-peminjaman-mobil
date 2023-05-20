<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Letter;
use App\Models\Signature;
use App\Models\UserManager;
use App\Models\Validation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil semua pengajuan
        $letters = letter::all();

        // ambil semua pengajuan yang masuk hari ini
        $letterTodays = Letter::whereDate('created_at', Carbon::today())->get();

        // ambil semua pengajuan yang telah disetujui
        $letterAccepteds = Letter::where('status', true)->get();

        // ambil semua pengajuan yang belum disetujui
        $letterProcesses = Letter::whereNull('status')->get();

        // ambil semua pengajuan yang belum diproses
        $letterNotConfirmeds = Letter::whereNull('status')->whereNull('car_id')->get();

        // jika ada pengajuan yang perlu di proses
        if (count($letterNotConfirmeds) > 0) {
            // beri notifikasi
            notyf()->addInfo('Ada ' . count($letterNotConfirmeds) . ' pengajuan yang harus dikonfirmasi');
        } else notyf()->addSuccess('Tidak ada pengajuan yang perlu dikonfirmasi');

        // ambil unit mobil yang bisa digunakan
        $cars = Car::where('status', false)->get();

        // kirim data ke view
        $data = [
            'page' => 'Pengajuan Masuk',
            'letters' => $letters,
            'letterTodays' => $letterTodays,
            'letterAccepteds' => $letterAccepteds,
            'letterProcesses' => $letterProcesses,
            'letterNotConfirmeds' => $letterNotConfirmeds,
            'cars' => $cars
        ];

        // return response()->json($data);

        // render view
        return view('pages.admin.letter.index', $data);
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
        try {
            // validasi request yang masuk
            $validate = $request->validate([
                'user_id' => 'required|numeric',
                'car_id' => 'required|numeric'
            ]);

            // cek apakah pemohon sudah memiliki tanda tangan digital nya
            $signature = Signature::where('user_id', $validate['user_id'])->first();

            if (!$signature) {
                // beri notifikasi
                notyf()->addInfo('Pemohon belum menambahkan tanda tangan digital ke dalam sistem');
                notyf()->addError('Konfirmasi pengajuan dibatalkan');

                // kembali ke halaman sebelumnya
                return redirect()->back();
            }

            // cek apakah pemohon memiliki data atasan
            $managers = UserManager::where('user_id', $validate['user_id'])->get();

            if (count($managers) == 0) {
                // beri notifikasi
                notyf()->addInfo('Atasan pemohon tidak ditemukan');
                notyf()->addError('Konfirmasi pengajuan dibatalkan');

                // kembali ke halaman sebelumnya
                return redirect()->back();
            }

            // ambil data pengajuan yang ingin di konfirmasi
            $letter = Letter::findOrfail($id);

            // ambil data unit mobil yang akan digunakan
            $car = Car::findOrFail($validate['car_id']);

            // masukkan car_id ke dalam pengajuan
            $letter->update(['car_id' => $car->id]);

            // ubah status unit mobil jadi true atau telah di gunakan
            $car->update(['status' => true]);

            // buat data validasi atau legalisir baru
            Validation::create([
                'letter_id' => $letter->id,
                'applicant_signature' => $signature->id,
                'deputy_signature' => null,
                'manager_signature' => null
            ]);

            // beri notifikasi
            notyf()->addSuccess('Pengajuan berhasil di konfirmasi');
            notyf()->addInfo('Mengunggu proses legalisir dari atasan dan deputi');
        } catch (ValidationException $err) {
            notyf()->addError($err->getMessage());
        }

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
