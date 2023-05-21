<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Car;
use App\Models\Letter;
use App\Models\Participant;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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

        // ambil surat yang baru saja di setujui
        $letterLastAccepted = Letter::where('user_id', $user->id)->latest()->first();

        if ($letterLastAccepted->status) {
            // beri notifikasi
            notyf()->addSuccess('Pengajuan pada kegiatan ' . $letterLastAccepted->name . ' telah disetujui');
        }

        // Ambil semua surat yang pernah dibuat tapi ditolak
        $letterRejecteds = Letter::where('user_id', $user->id)->where('status', false)->get();

        // Ambil apakah ada pengajuan yang masih di proses
        $letterProcess = Letter::where('user_id', $user->id)->whereNull('status')->first();

        // beri notifikasi jika masih terdapat pengajuan yang sedang di proses
        if ($letterProcess) notyf()->addInfo('Pengajuan terakhir anda masih sedang di proses');

        // Ambil mobil yang status nya tersedia
        $availableCars = Car::where('status', false)->get();

        // beri notifikasi jumlah mobil yang tersedia hanya jika tidak ada pengajuan yang belum disetujui
        if (!$letterLastAccepted->status) {
            if (count($availableCars) == 0) notyf()->addError('Tidak ada mobil yang tersedia untuk saat ini');
            else notyf()->addInfo('Saat ini hanya tersedia ' . count($availableCars) . ' mobil yang bisa digunakan');
        }

        // Kirim data ke view
        $data = [
            'page' => 'Pengajuan Peminjaman Mobil',
            'managers' => $managers,
            'letters' => $letters,
            'lastLetter' => $lastletter,
            'letterAccepteds' => $letterAccepteds,
            'letterLastAccepted' => $letterLastAccepted,
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

    // cetak surat pengajuan
    public function print($id)
    {
        $data = $this->generateLetterData($id);

        // beri notifikasi cara print berkas
        notyf()->addInfo('Surat anda siap untuk dicetak, gunakan CTRL + P untuk print surat');

        // render view
        return view('pages.user.letter.print', $data);
    }

    // unduh surat pengajuan
    public function download($id)
    {
        // ambil data yang mau di unduh
        $data = $this->generateLetterData($id);

        //  inisiasi PDF
        $pdf = Pdf::loadView('pages.user.letter.print', $data);

        return $pdf->download('Surat Pengajuan ' . $data['name'] . '.pdf');

        // return $pdf->stream();
    }

    // method untuk mengolah yang akan di cetak atau di unduh
    public function generateLetterData($id)
    {
        // ambil data pengajuan
        $letter = Letter::findOrFail($id);

        // hitung jumlah peserta berdasarkan gender
        $participants = $letter->participants;

        // pria
        $participantMales = $participants->filter(function ($participant) {
            return $participant->gender === 'Pria';
        })->count();

        // wanita
        $participantFemales = $participants->filter(function ($participant) {
            return $participant->gender === 'Wanita';
        })->count();

        // buat variabel untuk menyimpan kolom kosong peserta
        $emptyColumns = 0;
        $column = 3;

        if (count($participants) > $column) {
            // ambil sisa kolom peserta dari modulues $column
            $participantColumns = count($participants) % $column;
            $emptyColumns = $column - $participantColumns;
        } else {
            $emptyColumns = $column - count($participants);
        }

        // kirim data ke view
        $data = [
            'name' => $letter->name,
            'letter' => $letter,
            'participants' => $participants,
            'participantMales' => $participantMales,
            'participantFemales' => $participantFemales,
            'emptyColumns' => $emptyColumns
        ];

        return $data;
    }
}
