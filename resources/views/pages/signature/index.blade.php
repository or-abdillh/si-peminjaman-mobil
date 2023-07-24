@extends('layouts.soft-ui.app')

@push('before-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
@endpush

@push('before-scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/signature_pad/dist/signature_pad.umd.min.js" integrity="sha256-uGyFpu2wVfZ4h/KOsoT+7NdggPAEU2vXx0oNPEYq3J0=" crossorigin="anonymous"></script> --}}
@endpush

@section('content')
    <main class="container-fluid py-4">

        <section class="row mb-4">

            {{-- Menampilkan banyak surat yang menggunakan tanda tangan user --}}
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Digunakan Pada</p>
                                    <h6 class="font-weight-bolder mb-0">
                                        {{-- Melakukan perhitungan jumlah record yang didapat --}}
                                        {{ $usedByLetter }} Surat
                                    </h6>
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
            </div>

            {{-- Menampilkan kapan terakhir kali perbarui --}}
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pembaharuan</p>
                                    <h6 class="font-weight-bolder mb-0">
                                        {{ @$signature->updated_at ? @$signature->updated_at->diffForHumans() : 'Tidak ada data' }}
                                    </h6>
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
            </div>

            {{-- Menampilkan kapan tanda tangan dibuat --}}
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Direkam Pada</p>
                                    <h6 class="font-weight-bolder mb-0">
                                        {{ @$signature->created_at ? date('D, j F Y', strtotime(@$signature->created_at)) : 'Tidak ada data' }}
                                    </h6>
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
            </div>
        </section>

        {{-- menampilkan tanda tangan jika sudah memiliki --}}
        <section class="row mb-4">
            <section class="col">
                <section class="card">
                    <section class="card-body row">
                        <section class="col-12 row justify-content-between mb-2">
                            <div class="col-auto">
                                <h6 class="mb-1">
                                    @if (@$signature)
                                        Anda sudah memiliki tanda tangan digital
                                    @else
                                        Anda belum memiliki tanda tangan digital
                                    @endif
                                </h6>
                                <small class="text-secondary">
                                    @if (@$signature)
                                        Lihat gambar tanda tangan dibawah
                                    @else
                                        Gunakan alat rekam dibawah untuk mulai perekaman
                                    @endif
                                </small>
                            </div>
                            @if (@$signature)
                                <div class="col-auto">
                                    <a href="{{ asset('storage/signatures/' . $signature->image) }}" target="_blank"
                                        type="submit" class="btn btn-primary">Unduh</a>
                                </div>
                            @endif
                        </section>
                        <img src="{{ asset('storage/signatures/' . $signature->image) }}" class="img-thumbnail">
                    </section>
                </section>
            </section>
        </section>

        <section class="row mb-4">

            {{-- area merekam tanda tangan --}}
            <section class="col-xl-8">
                <section class="card">
                    <section class="card-body">
                        <header class="d-flex justify-content-between">
                            <section>
                                <h5 class="mb-1">Rekam Tanda Tangan</h5>
                                <small class="text-secondary">Gunakan mouse pad atau touch pada device touch screen</small>
                            </section>
                            <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa-solid text-lg fa-signature"></i>
                            </section>
                        </header>
                        <section class="w-full d-flex flex-column justify-center text-center">
                            <canvas id="canvas" width="500px" height="300px" class="mb-2"
                                style="border-bottom: 1.5px solid whitesmoke; cursor: crosshair;"></canvas>
                            <small class="text-secondary">Tanda Tangan Diatas</small>
                        </section>
                    </section>
                </section>
            </section>

            {{-- alat untuk proses rekam tanda tangan digital --}}
            <section class="col-xl-4">
                <section class="card">
                    <section class="card-body">
                        <h5 class="text-center mb-3">Alat</h5>
                        <section class="row">
                            {{-- simpan tanda tangan --}}
                            <form id="signature-form" action="{{ $route }}" method="POST">
                                @csrf
                                @if (@$signature)
                                    @method('PUT')
                                @endif
                                <input type="text" name="image" hidden>
                            </form>
                            <button data-role="btn-save" class="col-12 mb-2 btn btn-primary">
                                @if (@$signature)
                                    Perbarui
                                @else
                                    Simpan
                                @endif
                            </button>

                            {{-- batalkan tanda tangan --}}
                            <button data-role="btn-cancel" class="btn btn-info col-12 mb-2">Batalkan</button>

                            {{-- undo --}}
                            <button data-role="btn-undo" class="btn btn-secondary col-12 mb-2">Undo</button>

                            @if (@$signature)
                                {{-- hapus tanda tangan --}}
                                <button class="btn btn-danger mb-2 col-12" data-bs-toggle="modal"
                                    data-bs-target="#deleteSignatureModal">Hapus</button>
                            @endif
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </main>

    @if (@$signature)
        {{-- modal untuk menghapus tanda tangan --}}
        <div class="modal fade" id="deleteSignatureModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('signature.destroy', $signature->id) }}" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Tanda Tangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            @csrf
                            @method('DELETE')
                            <p>Anda yakin ingin menghapus tanda tangan anda? ini bersifat permanen</p>
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

    @push('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @endpush

    @push('after-scripts')
        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', () => {

                const canvas = document.querySelector('#canvas')
                const signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(255, 255, 255)'
                })

                // inisiasi Notyf
                const notyf = new Notyf()

                // Ambil semua tombol alat
                const btnSave = document.querySelector('[data-role=btn-save]')
                const btnUndo = document.querySelector('[data-role=btn-undo]')
                const btnCancel = document.querySelector('[data-role=btn-cancel]')

                // Ambil input dan form
                const imageInput = document.querySelector('[name=image]')
                const form = document.querySelector('#signature-form')

                btnSave.addEventListener('click', () => {
                    if (signaturePad.isEmpty()) notyf.error('Tanda tangan anda masih kosong')
                    else {
                        imageInput.value = signaturePad.toDataURL('image/jpeg')
                        form.submit()
                    }
                })

                btnUndo.addEventListener('click', () => {
                    var data = signaturePad.toData()

                    if (data && !signaturePad.isEmpty()) {
                        data.pop() // remove the last dot or line
                        signaturePad.fromData(data)
                    } else notyf.error('Tanda tangan anda masih kosong')
                })

                btnCancel.addEventListener('click', () => {
                    if (signaturePad.isEmpty()) notyf.error('Tanda tangan anda masih kosong')
                    else signaturePad.clear()
                })
            })
        </script>
    @endpush
@endsection
