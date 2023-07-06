@extends('layouts.soft-ui.app')

@push('before-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
@endpush

@section('content')

    <main class="container-fluid">

        {{-- statistik --}}
        <section class="row mb-4">
            {{-- Total pengajuan --}}
            <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- menampilkan hasil query --}}
                                        <h6>{{ @$letters }} Surat</h6>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Disetujui --}}
            <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Disetujui</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- menampilkan hasil query --}}
                                        <h6>{{ count(@$letterAccepteds) }} Surat</h6>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Ditolak --}}
            <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Ditolak</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- menampilkan hasil query --}}
                                        <h6>{{ count(@$letterRejecteds) }} Surat</h6>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Pengajuan terakhir --}}
            <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Ajuan Terakhir</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- menampilkan hasil query --}}
                                        <h6>{{ @$lastLetter ? $lastLetter->created_at->diffForHumans() : '-- : --' }}</h6>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>


        @if ($letterProcess)
            {{-- info proses pengajuan --}}
            <section class="row">
                <section class="col-9">
                    <section class="card">
                        <section class="card-body row">
                            <h5>Pengajuan sedang diproses</h5>
                            <small>Pengajuan anda pada kegiatan <strong>{{ $letterProcess->name }}</strong> yang akan
                                dilaksanakan pada {{ date('D, j F Y', strtotime($letterProcess->start_time)) }} saat ini
                                sedang <strong>Diproses</strong></small>
                        </section>
                    </section>
                </section>
                <section class="col-3">
                    <section class="card">
                        <section class="card-body row">
                            {{-- lihat pengajuan --}}
                            <button type="button" class="col-12 btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#showLetterModal">Lihat</button>
                            {{-- hapus pengajuan --}}
                            <button type="button" class="col-12 btn btn-danger mb-0" data-bs-toggle="modal"
                                data-bs-target="#deleteLetterModal">Batalkan</button>
                        </section>
                    </section>
                </section>
            </section>
        @elseif (@$letterLastAccepted)
            {{-- munculkan alert  --}}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Silahkan melakukan konfirmasi dengan menekan tombol <strong>Selesai</strong>, jika anda telah selesai
                menggunakan unit mobil dalam kegiatan {{ $letterLastAccepted->name }}
            </div>
            <section class="row mb-4">
                <section class="col-9">
                    <section class="card mb-4">
                        <section class="card-body row">
                            <h5>Pengajuan telah disetujui</h5>
                            <small>Pengajuan anda pada kegiatan <strong>{{ $letterLastAccepted->name }}</strong> yang akan
                                dilaksanakan pada {{ date('D, j F Y', strtotime($letterLastAccepted->start_time)) }} telah
                                <strong>Disetujui</strong></small>
                        </section>
                    </section>
                </section>
                <section class="col-3">
                    <section class="card">
                        <section class="card-body row">
                            {{-- cetak surat --}}
                            <a href="{{ route('user.letter.print', $letterLastAccepted->id) }}" target="_blank"
                                class="col-12 btn btn-success mb-3">Cetak</a>
                            {{-- konfirmasi selesai --}}
                            <button type="button" class="col-12 btn btn-danger mb-0" data-bs-toggle="modal"
                                data-bs-target="#confirmationModal">Selesai</button>
                        </section>
                    </section>
                </section>
            </section>
            {{-- infokan bahwa pengajuan terakhir ditolak --}}
        @elseif (@$letterLastRejected)
            <section class="row">
                <section class="col">
                    <section class="card mb-4">
                        <section class="card-body row">
                            <h5>Pengajuan ditolak</h5>
                            <small class="mb-3">Pengajuan anda pada kegiatan
                                <strong>{{ $letterLastRejected->name }}</strong> yang akan dilaksanakan pada
                                {{ date('D, j F Y', strtotime($letterLastRejected->start_time)) }} telah
                                <strong>Ditolak</strong></small>
                            {{-- lihat alasan --}}
                            <a href="javascript;;" style="text-decoration: underline" class="col-12 link-primary mb-0"
                                data-bs-toggle="modal" data-bs-target="#feedbackRejectModal">Lihat Alasan</a>
                        </section>
                    </section>
                </section>
            </section>
        @endif

        {{-- munculkan form jika tidak ada pengajuan yang sedang di proses dan disetujui --}}
        @if (!@$letterProcess && !@$letterLastAccepted)
            {{-- form pengajuan peminjaman --}}
            <section class="row mb-4">

                <form action="{{ route('user.letter.store') }}" method="POST" enctype="multipart/form-data"
                    class="col-lg-8 row">
                    {{-- form utama --}}
                    <section class="col-12 mb-4">
                        <section class="card">
                            <section class="card-header">
                                <header class="d-flex justify-content-between">
                                    <section>
                                        <h5>Formulir Pengajuan Peminjaman</h5>
                                        <small>Pastikan untuk melakukan pengisian formulir sebaik mungkin</small>
                                    </section>
                                    <section
                                        class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid text-lg fa-envelope-open-text"></i>
                                    </section>
                                </header>
                            </section>
                            <section class="card-body">
                                <section>
                                    @csrf
                                    {{-- waktu penggunaan --}}
                                    <section class="row mb-3">
                                        {{-- waktu mulai --}}
                                        <section class="col">
                                            <label>Waktu mulai</label>
                                            <input type="datetime-local" name="start_time" placeholder="Waktu mulai"
                                                class="form-control @error('start_time') is-invalid @enderror" required>
                                            @error('start_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </section>

                                        {{-- waktu selesai --}}
                                        <section class="col">
                                            <label>Waktu selesai</label>
                                            <input type="datetime-local" name="finish_time" placeholder="Waktu mulai"
                                                class="form-control @error('finish_time') is-invalid @enderror" required>
                                            @error('finish_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </section>
                                    </section>

                                    {{-- tempat tujuan --}}
                                    <section class="mb-3">
                                        <label>Tempat tujuan</label>
                                        <input type="text"
                                            class="form-control @error('destination_place') is-invalid @enderror"
                                            name="destination_place" placeholder="cnth: Stadion 17 Mei" required>
                                        @error('destination_place')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </section>

                                    {{-- tempat jemput --}}
                                    <section class="mb-3">
                                        <label>Tempat jemput</label>
                                        <input type="text"
                                            class="form-control @error('pickup_place') is-invalid @enderror"
                                            name="pickup_place"
                                            placeholder="cnth: Lobby depan atau belakang, Lobby Dormitory, Area jualan cafe, dll"
                                            required>
                                        @error('pickup_place')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </section>

                                    {{-- lampiran --}}
                                    <section class="mb-3">
                                        <label>Dokumen pendukung / PDF</label>
                                        <input type="file"
                                            class="form-control @error('attachment') is-invalid @enderror"
                                            name="attachment" accept="application/pdf">
                                        @error('attachment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </section>
                                </section>
                            </section>
                        </section>
                    </section>

                    {{-- form aktivitas --}}
                    <section class="col-12 mb-4">
                        <section class="card">
                            <section class="card-body">
                                <section class="mb-4 d-flex justify-content-between align-items-center">
                                    <section>
                                        <h5>Kegiatan</h5>
                                        <small>Isi form dibawah untuk menambahkan estimasi kegiatan</small>
                                    </section>
                                    <section
                                        class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid fa-business-time text-lg"></i>
                                    </section>
                                </section>
                                {{-- nama kegiatan --}}
                                <section class="mb-3">
                                    {{-- revisi: menambahkan nama label inputan --}}
                                    <label>Nama Kegiatan</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="cnth: Pertandingan Sepak Bola Paman Birin Cup"
                                        required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </section>

                                {{-- estimasi --}}
                                <section class="row mb-3">
                                    {{-- estimasi waktu --}}
                                    <section class="col-4">
                                        {{-- revisi: menambahkan nama label inputan --}}
                                        <label>Estimasi Waktu</label>
                                        <input type="text" name="estimation_times[]" class="form-control"
                                            placeholder="Estimasi Waktu" required>
                                    </section>
                                    {{-- estimasi kegiatan --}}
                                    <section class="col-8">
                                        <label>Estimasi Kegiatan</label>
                                        <input type="text" name="estimations[]" class="form-control"
                                            placeholder="Estimasi Kegiatan" required>
                                    </section>
                                </section>

                                <section id="estimation-wrapper" class="mb-4"></section>

                                {{-- tombol tambah dan hapus input estimasi --}}
                                <section class="row p-2 gap-4">
                                    <button data-role="btn-add-estimation-input" type="button"
                                        class="btn btn-primary col">Tambah</button>
                                    <button data-role="btn-delete-estimation-input" type="button"
                                        class="btn btn-danger col">Hapus</button>
                                </section>
                            </section>
                        </section>
                    </section>

                    {{-- form peserta --}}
                    <section class="col-12 mb-4">
                        <section class="card">
                            <section class="card-body">
                                <section class="mb-4 d-flex justify-content-between align-items-center">
                                    <section>
                                        <h5>Peserta</h5>
                                        <small>Tambahkan informasi peserta kegiatan</small>
                                    </section>
                                    <section
                                        class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid fa-user-group text-lg"></i>
                                    </section>
                                </section>
                                {{-- peserta --}}
                                <section class="row mb-3">
                                    <section class="col-7 ">
                                        {{-- revisi: menambahkan nama label inputan --}}
                                        <label>Nama</label>
                                        {{-- nama --}}
                                        <input type="text" name="participant_names[]"
                                            placeholder="cnth: Novi Marliana" class="form-control" required>
                                    </section>
                                    <section class="col-5">
                                        {{-- revisi: menambahkan nama label inputan --}}
                                        <label>Gender</label>
                                        {{-- kelamin --}}
                                        <select name="participant_genders[]" class="form-select" required>
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita">Wanita</option>
                                        </select>
                                    </section>
                                </section>

                                <section id="participant-wrapper" class="mb-4"></section>

                                {{-- tombol tambah dan hapus input peserta --}}
                                <section class="row p-2 gap-4">
                                    <button data-role="btn-add-participant-input" type="button"
                                        class="btn btn-primary col">Tambah</button>
                                    <button data-role="btn-delete-participant-input" type="button"
                                        class="btn btn-danger col">Hapus</button>
                                </section>
                            </section>
                        </section>
                    </section>

                    {{-- submit form pengajuan --}}
                    <section class="col-12">
                        <section class="card">
                            <section class="card-body">
                                <strong>Catatan</strong>
                                <ol>
                                    <li>Guru/Asatidz/Staff yang mendampingi siswa (ikut serta dalam keiatan)</li>
                                    <li>Pengajuan dibuat minimal sehari sebelum kegiatan (jangan mendadak) dan diserahkan ke
                                        GS Officer pada waktu jam kerja</li>
                                    <li>Form pengajuan untuk kegiatan beberapa hari harap melampirkan jadwal kegiatan atau
                                        acara</li>
                                    <li>Apabila ada pembatalan pengajuan, segera menginformasikan ke GS</li>
                                </ol>

                                {{-- kirim --}}
                                <section class="row p-2">
                                    <button type="submit" class="btn btn-success col-12">Kirim Pengajuan</button>
                                </section>
                            </section>
                        </section>
                    </section>
                </form>

                {{-- informasi pendamping --}}
                <section class="col-lg-4">
                    <section class="card">
                        <section class="card-header">
                            <h5>Informasi Pendamping</h5>
                            <small class="text-secondary">Pastikan anda sudah melengkapi profile anda</small>
                        </section>
                        <section class="card-body text-end">
                            {{-- nama --}}
                            <section class="mb-3">
                                <strong>Nama</strong>
                                <p>{{ auth()->user()->name }}</p>
                            </section>
                            {{-- email --}}
                            <section class="mb-3">
                                <strong>Email</strong>
                                <p>{{ auth()->user()->email }}</p>
                            </section>
                            {{-- telepon --}}
                            <section class="mb-3">
                                <strong>No. HP</strong>
                                <p>{{ auth()->user()->phone_number ? auth()->user()->phone_number : 'Tidak ada data' }}</p>
                            </section>
                            {{-- Atasan --}}
                            <section class="mb-3">
                                <strong>Atasan</strong>
                                @if (count($managers) > 0)
                                    @foreach ($managers as $manager)
                                        <p>{{ $manager->managerDetail->name }}</p>
                                    @endforeach
                                @else
                                    <p>Tidak ada data</p>
                                @endif
                            </section>
                            {{-- jabatan --}}
                            <section class="mb-3">
                                <strong>Jabatan</strong>
                                <p>{{ auth()->user()->position ? auth()->user()->position : 'Tidak ada data' }}</p>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        @endif

    @if (@$letterProcess)
    {{-- modal untuk menampilkan detail pengajuan yang sedang di prosess atau yang disetujui--}}
    <div class="modal fade" id="showLetterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <section class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <section>
                        <small class="text-secondary">Kegiatan</small>
                        <h6>{{ @$letterProcess->name }}</h6>
                    </section>
                    <section>
                        <small>Waktu kegiatan</small>
                        <h6>Dari {{ date('D, j F Y H:i', strtotime(@$letterProcess->start_time)) }} sampai {{ date('D, j F Y H:i', strtotime(@$letterProcess->finish_time)) }}</h6>
                    </section>
                    <section class="row">
                        <section class="col">
                            <small>Peserta</small>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$letterProcess->participants as $participant)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $participant->name }}</td>
                                        <td>{{ $participant->gender }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                        <section class="col">
                            <small>Aktivitas</small>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Estimasi Waktu</th>
                                        <th>Estimasi Kegiatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$letterProcess->activities as $activity)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $activity->estimation_time }}</td>
                                        <td>{{ $activity->estimation }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                    </section>
                </div>
                <div class="modal-footer">
                    {{-- lihat lampiran --}}
                    @if ($letterProcess->attachment)
                    <a href="{{ asset('storage/attachments/' . @$letterProcess->attachment) }}" target="_blank" class="btn btn-info">Lihat lampiran</a>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </section>
        </div>
    </div>
    @if ($letterProcess)
    {{-- modal untuk menghapus detail pengajuan --}}
    <div class="modal fade" id="deleteLetterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('user.letter.destroy', $letterProcess->id) }}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Batalkan Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        @csrf
                        @method('DELETE')
                        <p>Anda yakin ingin membatalkan pengajuan ini? pastikan anda sudah menghubungi admin perihal pembatalan</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>   
    @endif
    @endif

        {{-- modal untuk melihat alasan penolakan --}}
        @if (@$letterLastRejected)
            <div class="modal fade" id="feedbackRejectModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <form class="modal-dialog" action="{{ route('user.letter.confirmation', $letterLastRejected->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <section class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pengajuan Ditolak</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Pengajuan anda pada kegiatan <strong>{{ $letterLastRejected->name }}</strong> ditolak oleh
                                admin, dengan alasan sebagai berikut</p>
                            <div class="mb-2">
                                <textarea readonly disabled cols="30" rows="5" class="form-control">{{ $letterLastRejected?->feedback?->body }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Confirmation</button>
                        </div>
                    </section>
                </form>
            </div>
        @endif

        {{-- modal untuk menyatakan selesai menggunakan unit --}}
        @if (@$letterLastAccepted)
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <form class="modal-dialog" action="{{ route('user.letter.confirmation', $letterLastAccepted->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <section class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Selesai</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah anda ingin melakukan konfirmasi bahwa pengajuan peminjaman unit mobil
                                <strong>{{ $letterLastAccepted->car->name }}</strong> pada kegiatan
                                <strong>{{ $letterLastAccepted->name }}</strong> yang dilaksanakan pada
                                {{ date('j F Y', strtotime($letterLastAccepted->start_time)) }} telah selesai?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Confirmation</button>
                        </div>
                    </section>
                </form>
            </div>
        @endif
    </main>

    @push('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @endpush

    @push('after-scripts')
        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', () => {

                // inisiasi notyf
                const notyf = new Notyf()

                // ambil tombol tambah dan hapus input estimasi kegiatan
                const btnAddEstimationInput = document.querySelector('[data-role=btn-add-estimation-input]')
                const btnDeleteEstimationInput = document.querySelector('[data-role=btn-delete-estimation-input]')

                // ambil parent element
                const estimationParentElement = document.querySelector('#estimation-wrapper')

                // buat element baru saat tombol tambah di klik
                btnAddEstimationInput.addEventListener('click', () => {
                    estimationParentElement.appendChild(createEstimationElement())
                })

                // hapus element terakhir saat tombol hapus di klik
                btnDeleteEstimationInput.addEventListener('click', () => {
                    // jika tersisa satu inputan
                    if (estimationParentElement.childElementCount == 0) notyf.error(
                        'Minimal terdapat satu estimasi kegiatan')
                    else estimationParentElement.removeChild(estimationParentElement.lastChild)
                })

                // method untuk membuat element input estimasi baru
                const createEstimationElement = () => {

                    // Membuat elemen <section> dengan kelas "row mb-3"
                    const sectionElement = document.createElement('section')
                    sectionElement.classList.add('row', 'mb-3')

                    // Membuat elemen <section> dengan kelas "col-4" untuk estimasi waktu
                    const estimationTimeElement = document.createElement('section')
                    estimationTimeElement.classList.add('col-4')

                    // Membuat elemen <input> untuk estimasi waktu
                    const estimationTimeInput = document.createElement('input')
                    estimationTimeInput.setAttribute('type', 'text')
                    estimationTimeInput.setAttribute('name', 'estimation_times[]')
                    estimationTimeInput.classList.add('form-control')
                    estimationTimeInput.setAttribute('placeholder', 'Estimasi Waktu')

                    // revisi menambahkan nama label inputan "Estimasi Waktu"
                    const estimationTimeLabel = document.createElement('label')
                    estimationTimeLabel.textContent = 'Estimasi Waktu'
                    estimationTimeElement.appendChild(estimationTimeLabel)

                    // Menambahkan input estimasi waktu ke elemen estimasi waktu
                    estimationTimeElement.appendChild(estimationTimeInput)

                    // Membuat elemen <section> dengan kelas "col-8" untuk estimasi kegiatan
                    const estimationElement = document.createElement('section')
                    estimationElement.classList.add('col-8')

                    // Membuat elemen <input> untuk estimasi kegiatan
                    const estimationInput = document.createElement('input')
                    estimationInput.setAttribute('type', 'text')
                    estimationInput.setAttribute('name', 'estimations[]')
                    estimationInput.classList.add('form-control')
                    estimationInput.setAttribute('placeholder', 'Estimasi Kegiatan')

                    // revisi menambahkan nama label inputan "Estimasi Kegiatan"
                    const estimationLabel = document.createElement('label')
                    estimationLabel.textContent = 'Estimasi Kegiatan'
                    estimationElement.appendChild(estimationLabel)

                    // Menambahkan input estimasi kegiatan ke elemen estimasi kegiatan
                    estimationElement.appendChild(estimationInput)

                    // Menambahkan elemen estimasi waktu dan estimasi kegiatan ke elemen utama
                    sectionElement.appendChild(estimationTimeElement)
                    sectionElement.appendChild(estimationElement)

                    // return element baru
                    return sectionElement
                }

                // ambil tombol tambah dan hapus inputan peserta
                const btnAddParticipantInput = document.querySelector('[data-role=btn-add-participant-input]')
                const btnDeleteParticipantInput = document.querySelector('[data-role=btn-delete-participant-input]')

                // ambil parent element
                const participantParentElement = document.querySelector('#participant-wrapper')

                // buat inputan peserta baru saat tombol tambah peserta diklik
                btnAddParticipantInput.addEventListener('click', () => {
                    participantParentElement.appendChild(createParticipantElement())
                })

                // hapus element inputan peserta saat tombol hapus di klik
                btnDeleteParticipantInput.addEventListener('click', () => {
                    // jika tersisa satu inputan
                    if (participantParentElement.childElementCount == 0) notyf.error(
                        'Minimal terdapat satu peserta')
                    else participantParentElement.removeChild(participantParentElement.lastChild)
                })

                // method untuk membuat element input peserta baru
                const createParticipantElement = () => {
                    // Membuat elemen <section> dengan kelas "row mb-3"
                    const sectionElement = document.createElement('section')
                    sectionElement.classList.add('row', 'mb-3')

                    // Membuat elemen <section> dengan kelas "col-7" untuk nama peserta
                    const nameElement = document.createElement('section')
                    nameElement.classList.add('col-7')

                    // revisi menambahkan label pada inputan "Nama"
                    const nameLabel = document.createElement('label')
                    nameLabel.textContent = 'Nama'
                    nameElement.appendChild(nameLabel)

                    // Membuat elemen <input> untuk nama peserta
                    const nameInput = document.createElement('input')
                    nameInput.setAttribute('type', 'text')
                    nameInput.setAttribute('name', 'participant_names[]')
                    nameInput.setAttribute('placeholder', 'Contoh: Novi Marliana')
                    nameInput.classList.add('form-control')

                    // Menambahkan input nama peserta ke elemen nama
                    nameElement.appendChild(nameInput)

                    // Membuat elemen <section> dengan kelas "col-5" untuk kelamin peserta
                    const genderElement = document.createElement('section')
                    genderElement.classList.add('col-5')

                    // revisi menambahkan label pada inputan "Gender"
                    const genderLabel = document.createElement('label')
                    genderLabel.textContent = 'Gender'
                    genderElement.appendChild(genderLabel)

                    // Membuat elemen <select> untuk kelamin peserta
                    const genderSelect = document.createElement('select')
                    genderSelect.setAttribute('name', 'participant_genders[]')
                    genderSelect.classList.add('form-select')

                    // Membuat elemen <option> untuk opsi "Pria"
                    const optionMale = document.createElement('option')
                    optionMale.setAttribute('value', 'Pria')
                    optionMale.textContent = 'Pria'

                    // Membuat elemen <option> untuk opsi "Wanita"
                    const optionFemale = document.createElement('option')
                    optionFemale.setAttribute('value', 'Wanita')
                    optionFemale.textContent = 'Wanita'

                    // Menambahkan opsi ke elemen select
                    genderSelect.appendChild(optionMale)
                    genderSelect.appendChild(optionFemale)

                    // Menambahkan elemen select kelamin peserta ke elemen kelamin
                    genderElement.appendChild(genderSelect)

                    // Menambahkan elemen nama dan elemen kelamin ke elemen utama
                    sectionElement.appendChild(nameElement)
                    sectionElement.appendChild(genderElement)

                    // return element baru
                    return sectionElement
                }
            })
        </script>
    @endpush

@endsection
