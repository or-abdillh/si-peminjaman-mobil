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
use Illuminate\Support\Facades\Storage;

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
        $letters = Letter::withTrashed()->where('user_id', $user->id)->count();

        // Ambil data pengajuan terakhir
        $lastletter = $user->letters->last();

        // Ambil semua surat yang pernah dibuat dan di telah disetujui
        $letterAccepteds = Letter::withTrashed()->where('user_id', $user->id)->where('status', true)->get();

        // ambil surat yang baru saja di kirim
        $letterLastSubmitted = Letter::where('user_id', $user->id)->latest()->first();

        // cek apakah itu surat yang disetujui
        if ($letterLastSubmitted && $letterLastSubmitted->status) {
            // beri notifikasi
            notyf()->addSuccess('Pengajuan pada kegiatan ' . $letterLastSubmitted->name . ' telah disetujui');
            $letterLastAccepted = $letterLastSubmitted;
        }

        // cek apakah itu surat yang di tolak
        if ($letterLastSubmitted && !$letterLastSubmitted->status && !is_null($letterLastSubmitted->status)) {
            // beri notifikasi
            notyf()->addError('Pengajuan pada kegiatan ' . $letterLastSubmitted->name . ' ditolak oleh admin');
            $letterLastRejected = $letterLastSubmitted;
        }

        // Ambil semua surat yang pernah dibuat tapi ditolak
        $letterRejecteds = Letter::withTrashed()->where('user_id', $user->id)->where('status', false)->get();

        // Ambil apakah ada pengajuan yang masih di proses
        $letterProcess = Letter::where('user_id', $user->id)->whereNull('status')->first();

        // beri notifikasi jika masih terdapat pengajuan yang sedang di proses
        if ($letterProcess) notyf()->addInfo('Pengajuan terakhir anda masih sedang di proses');

        // Ambil mobil yang status nya tersedia
        $availableCars = Car::where('status', false)->get();

        // beri notifikasi jumlah mobil yang tersedia hanya jika tidak ada pengajuan yang belum disetujui
        if (count($availableCars) == 0) notyf()->addError('Tidak ada mobil yang tersedia untuk saat ini');
        else notyf()->addInfo('Saat ini hanya tersedia ' . count($availableCars) . ' mobil yang bisa digunakan');

        // Kirim data ke view
        $data = [
            'page' => 'Pengajuan Peminjaman Mobil',
            'managers' => $managers,
            'letter' => $letterProcess ?? $letterLastAccepted ?? null,
            'letters' => $letters,
            'lastLetter' => $lastletter,
            'letterAccepteds' => $letterAccepteds,
            'letterLastAccepted' => $letterLastAccepted ?? null,
            'letterLastRejected' => $letterLastRejected ?? null,
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
            'attachment' => 'nullable',
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

            // membuat data peserta ke dalam tabel Participant
            foreach ($validate['participant_names'] as $key => $participant) {
                Participant::create([
                    'letter_id' => $letter->id,
                    'name' => $participant,
                    'gender' => $validate['participant_genders'][$key]
                ]);
            }

            // membuat estimasi kegiatan ke dalam tabel Activity
            foreach ($validate['estimations'] as $key => $estimation) {
                Activity::create([
                    'letter_id' => $letter->id,
                    'estimation' => $estimation,
                    'estimation_time' => $validate['estimation_times'][$key]
                ]);
            };

            // upload dokumen pendukung
            if ($request->hasFile('attachment')) {
                // ambil file
                $file = $request->file('attachment');

                // generate nama dokumen
                $filename = uniqid() . "." . $file->getClientOriginalExtension();

                // simpan file ke storage/app/public/attachments
                $file->storeAs('public/attachments', $filename);

                // simpan informasi nama file ke dalam database
                $letter->update(['attachment' => $filename]);
            }

            // beri noifikasi berhasil
            notyf()->addSuccess('Berhasil mengirim pengajuan peminjaman mobil');
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

        // hapus lampiran jika ada
        if ($letter->attachment) {
            // ambil path lampiran 
            $path = 'public/attachments/' . $letter->attachment;

            // apakah lampiran ada di storage
            if (Storage::exists($path)) Storage::delete($path);
        }

        // hapus pengajuan
        $letter->forceDelete();

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

        // render view
        return view('pages.user.letter.print', $data);
    }

    // method untuk mengolah yang akan di cetak atau di unduh
    public function generateLetterData($id)
    {
        // ambil data pengajuan berdasarkan user yang saat ini sedang login
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

        // ambil data legalisir pada pengajuan
        $validation = $letter->validation;

        if (!$validation) {
            // beri notifikasi
            notyf()->addInfo('Legalisir belum diajukan');

            $signatures = null;
        } else {
            // tanda tangan dalam bentuk base64
            $signatures = [
                'deputySignature' => $this->imageToBase64($validation?->deputySignature?->image ?? null),
                'managerSignature' => $this->imageToBase64($validation?->managerSignature?->image ?? null),
                'applicantSignature' => $this->imageToBase64($validation?->applicantSignature?->image ?? null)
            ];
        }

        // kirim data ke view
        $data = [
            'name' => $letter->name,
            'letter' => $letter,
            'participants' => $participants,
            'participantMales' => $participantMales,
            'participantFemales' => $participantFemales,
            'emptyColumns' => $emptyColumns,
            'signatures' => $signatures,
        ];

        return $data;
    }

    // method untuk konfirmasi selesai menggunakan unit mobil berdasarkan pengajuan
    public function confirmation($id)
    {
        // ambil data surat pengajuan
        $letter = Letter::findOrFail($id);

        // ambil data unit mobil yang digunakan
        $car = $letter->car;

        // ubah status unit mobil dari true ke false atau tersedia
        if ($car) $car->update(['status' => false]);

        // hapus data pengajuan
        $letter->delete();

        // beri notifikasi
        notyf()->addSuccess('Konfirmasi dari anda berhasil diterima');
        notyf()->addInfo('Silahkan mengisi form pengajuan lagi jika diperlukan');

        // kembali ke halaman sebelumnya
        return redirect()->back();
    }

    // method untuk membuat tanda tangan menjadi base64
    public function imageToBase64($image)
    {
        // buat path menuju file image
        $path = 'signatures/' . $image;

        // ambil dari storage
        $file = Storage::disk('public')->get($path);

        // konversi ke dalam bentuk base64
        $base64 = base64_encode($file);

        return 'data:image/png;base64,' . $base64;
    }
}
