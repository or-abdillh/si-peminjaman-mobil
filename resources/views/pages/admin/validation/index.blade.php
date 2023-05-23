@extends('layouts.soft-ui.app')

@section('content')

<main class="container-fluid">

    <section class="row mb-4">

        {{-- semua legalisir --}}
        <div class="col-xl-4 col-sm-6 mb-xl-0">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total legalisir</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ count(@$validations) }} Pengajuan
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
        </div>

        {{-- hari ini --}}
        <div class="col-xl-4 col-sm-6 mb-xl-0">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Hari ini</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ count(@$validationTodays) }} Pengajuan
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
        </div>
        
        {{-- perlu di setujui --}}
        <div class="col-xl-4 col-sm-6 mb-xl-0">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Perlu Disetujui</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ count(@$validationProcesses) }} Pengajuan
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
        </div>

    </section>
    
    {{-- tabel untuk pengajuan yang perlu di setujui legalisir nya --}}
    <section class="row mb-4">
        <section class="col">
            <section class="card">
                <section class="card-header d-flex justify-content-between align-items-center">
                    <section>
                        <h5>Perlu Persetujuan</h5>
                        <small class="text-secondary">Silahkan untuk memberikan persetujuan pada pengajuan berikut</small>
                    </section>
                    <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                    </section>
                </section>
                <section class="card-body">
                    <div class="table-responsive p-4">
                        <table id="table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Diajukan</th>
                                    <th>TTD Pemohon</th>
                                    <th>TTD Atasan</th>
                                    <th>TTD Deputy</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$validationProcesses as $letter)
                                <tr>
                                    <td>{{ @$letter->name }}</td>
                                    <td>{{ @$letter->user->name }}</td>
                                    <td class="text-center">
                                        @if (@$letter->validation->applicantSignature->image)
                                        {{-- tombol untuk memunculkan modal lihat tanda tangan     --}}
                                        <a href="javascript;;" data-signature="{{ json_encode([ 'image' => asset('storage/signatures/' . @$letter->validation->applicantSignature->image), 'name' => @$letter->validation->applicantSignature->user->name ]) }}" data-role="btn-show" data-bs-toggle="modal" data-bs-target="#showSignatureModal" class="text-info me-2 font-weight-bold text-xs" data-toggle="tooltip">Lihat</a>
                                        @else
                                        Tidak ada data
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (@$letter->validation->managerSignature->image)
                                        {{-- tombol untuk memunculkan modal lihat tanda tangan     --}}
                                        <a href="javascript;;" data-signature="{{ json_encode([ 'image' => asset('storage/signatures/' . @$letter->validation->managerSignature->image), 'name' => @$letter->validation->managerSignature->user->name ]) }}" data-role="btn-show" data-bs-toggle="modal" data-bs-target="#showSignatureModal" class="text-info me-2 font-weight-bold text-xs" data-toggle="tooltip">Lihat</a>
                                        @else
                                        Tidak ada data
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (@$letter->validation->deputySignature->image)
                                        {{-- tombol untuk memunculkan modal lihat tanda tangan     --}}
                                        <a href="javascript;;" data-signature="{{ json_encode([ 'image' => asset('storage/signatures/' . @$letter->validation->deputySignature->image), 'name' => @$letter->validation->deputySignature->user->name ]) }}" data-role="btn-show" data-bs-toggle="modal" data-bs-target="#showSignatureModal" class="text-info me-2 font-weight-bold text-xs" data-toggle="tooltip">Lihat</a>
                                        @else
                                        Tidak ada data
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- tombol untuk memunculkan modal konfirmasi persetujuan --}}
                                        <a href="javascript;;" data-letter="{{ json_encode([ 'id' => @$letter->id ]) }}" data-role="btn-approve" data-bs-toggle="modal" data-bs-target="#formApproveModal" class="text-success me-2 font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Setujui">Setujui</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </section>
        </section>
    </section>

</main>

{{-- modal untuk menampilkan tanda tangan --}}
<div class="modal fade" id="showSignatureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <section class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <img src="" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </section>
    </div>
</div>

{{-- modal untuk konfirmasi legalisir --}}
<div class="modal fade" id="formApproveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Setujui Legalisir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    @csrf
                    @method('PUT')
                    <p>Dengan menyetujui legalisir, pemohon akan diberikan hak untuk dapat menggunakan unit mobil sesuai pengajuan</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('after-scripts')
{{-- Script JS untuk inisiasi tabel --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable()
    })
</script>

{{-- script js untuk menampilkan modal show tanda tangan --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

    // ambil semua tombol lihat pada tabel
    const btnShows = document.querySelectorAll('[data-role=btn-show]')

    // amil modal lihat tanda tangan
    const signatureModal = {
        image: document.querySelector('#showSignatureModal img'),
        heading: document.querySelector('#showSignatureModal h5'),
    }

    // munculkan modal saat tombol lihat di klik
    btnShows.forEach(btn => {
        btn.addEventListener('click', () => {

            // ambil image dan nama
            const { image, name } = JSON.parse( btn.dataset.signature )

            // tampilkan tanda tangan pada modal
            signatureModal.image.setAttribute('src', image)
            signatureModal.heading.innerHTML = 'Tanda tangan ' + name
        })  
    })
})

</script>

{{-- script js untuk konfirmasi menyetujui legalisir --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

    // ambil semua tombol setujui pada tabel
    const btnApproves = document.querySelectorAll('[data-role=btn-approve]')

    // ambil modal konfirmasi
    const confirmModal = document.querySelector('#formApproveModal form')

    // munculkan modal saat tombol setujui di klik
    btnApproves.forEach(btn => {
        btn.addEventListener('click', () => {

            // ambil id pengajuan
            const { id } = JSON.parse( btn.dataset.letter )

            // ubah attribute action pada form
            confirmModal.setAttribute('action', '/admin/validation/' + id)
        })
    })
})

</script>
@endpush