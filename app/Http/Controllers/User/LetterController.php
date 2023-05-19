<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Car;
use App\Models\Letter;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil data user yang saat ini login
        $user = User::find(Auth::user()->id);

        // Cek apakah user sudah memiliki manager
        $managers = $user->managedBy;

        if (count($managers) == 0) {
            notyf()->addError('Anda belum memiliki data atasan');
            notyf()->addInfo('Silahkan hubungi admin atau atasan anda untuk perubahan data');
        }

        // hitung semua surat yang pernah diajukan
        $letters = $user->letters->count();

        // Ambil data pengajuan terakhir
        $lastletter = $user->letters->last();

        // Ambil semua surat yang pernah dibuat dan di telah disetujui
        $letterAccepteds = Letter::where('user_id', $user->id)->where('status', true)->get();

        // Ambil semua surat yang pernah dibuat tapi ditolak
        $letterRejecteds = Letter::where('user_id', $user->id)->where('status', false)->get();

        // Ambil apakah ada pengajuan yang masih di proses
        $letterProcess = Letter::where('user_id', $user->id)->whereNull('status')->first();

        // beri notifikasi jika masih terdapat pengajuan yang sedang di proses
        if ($letterProcess) notyf()->addInfo('Pengajuan terakhir anda masih sedang di proses');

        // Ambil mobil yang status nya tersedia
        $availableCars = Car::where('status', true)->get();

        // beri notifikasi jumlah mobil yang tersedia
        if (count($availableCars) == 0) notyf()->addError('Tidak ada mobil yang tersedia untuk saat ini');
        else notyf()->addInfo('Saat ini hanya tersedia ' . count($availableCars) . ' mobil yang bisa digunakan');

        // Kirim data ke view
        $data = [
            'page' => 'Pengajuan Peminjaman Mobil',
            'managers' => $managers,
            'letters' => $letters,
            'lastLetter' => $lastletter,
            'letterAccepteds' => $letterAccepteds,
            'letterRejecteds' => $letterRejecteds,
            'letterProcess' => $letterProcess,
            'availableCars' => $availableCars
        ];

        // return response()->json($data);

        // render view
        return view('pages.user.letter.index', $data);
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
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'finish_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'destination_place' => 'required|string',
            'pickup_place' => 'required|string',
            'name' => 'required|string',
            'estimation_times.*' => 'nullable',
            'estimations.*' => 'nullable',
            'participant_names.*' => 'nullable',
            'participant_genders.*' => 'nullable',
            'estimation_times' => 'required_without_all:estimation_times.*',
            'estimations' => 'required_without_all:estimations.*',
            'participant_names' => 'required_without_all:participant_names.*',
            'participant_genders' => 'required_without_all:participant_genders.*',
        ]);

        try {
            // membuat pengajuan baru berdasarkan user yang sedang login
            $letter = Letter::create([
                'user_id' => Auth::user()->id,
                'start_time' => $validate['start_time'],
                'finish_time' => $validate['finish_time'],
                'destination_place' => $validate['destination_place'],
                'pickup_place' => $validate['pickup_place'],
                'name' => $validate['name'],
                'status' => null
            ]);

            // beri noifikasi berhasil
            notyf()->addSuccess('Berhasil mengirim pengajuan peminjaman mobil');

            // membuat data peserta ke dalam tabel Participant
            foreach ($validate['participant_names'] as $key => $participant) {
                Participant::create([
                    'letter_id' => $letter->id,
                    'name' => $participant,
                    'gender' => $validate['participant_genders'][$key]
                ]);
            }

            // beri notifikasi berhasil
            notyf()->addInfo('Peserta telah ditambahkan ke dalam kegiatan ' . $letter->name);

            // membuat estimasi kegiatan ke dalam tabel Activity
            foreach ($validate['estimations'] as $key => $estimation) {
                Activity::create([
                    'letter_id' => $letter->id,
                    'estimation' => $estimation,
                    'estimation_time' => $validate['estimation_times'][$key]
                ]);
            };

            // beri notifikasi berhasil
            notyf()->addInfo('Detail kegiatan telah ditambahkan untuk kegiatan ' . $letter->name);
        } catch (QueryException $err) {
            notyf()->addError($err->getMessage());
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
        // ambil data pengajuan yang akan di batalkan
        $letter = Letter::findOrFail($id);

        // hapus semua data peserta yang terkait
        Participant::where('letter_id', $letter->id)->delete();

        // hapus semua aktivitas yang terkait
        Activity::where('letter_id', $letter->id)->delete();

        // hapus pengajuan
        $letter->delete();

        // beri notfikasi berhasil
        notyf()->addSuccess('Berhasil membatalkan pengajuan peminjaman');
        notyf()->addInfo('Silahkan melakukan pengajuan lagi jika diperlukan');

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
