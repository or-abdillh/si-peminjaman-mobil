@extends('layouts.soft-ui.app')

@section('content')

<main class="container-fluid">

    {{-- statistik --}}
    <section class="row mb-4">

        {{-- Pengajuan oleh bawahan --}}
        <div class="col-xl-6 col-sm-6 mb-xl-0">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Semua Pengajuan</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $letters }} Pengajuan
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

        {{-- Pengajuan yang perlu di legalisir --}}
        <div class="col-xl-6 col-sm-6 mb-xl-0">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pengajuan Yang Perlu Dilegalisir</p>
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
    </section>

    {{-- tabel legalisir --}}
    <section class="row mb-4">
        <section class="col">
            <section class="card">
                <section class="card-header d-flex justify-content-between align-items-center">
                    <section>
                        <h5>Pengajuan Perlu Diproses</h5>
                        <small>Silahkan melakukan legalisir pada pengajuan yang masuk ke anda</small>
                    </section>
                    <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                    </section>
                </section>
                <section class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-striped p-4">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Pendamping</th>
                                    <th>Posisi</th>
                                    <th>Atasan</th>
                                    <th>Diajukan</th>
                                    <th>Peserta</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$validations as $validation)
                                <tr>
                                    <td>{{ @$validation->letter->name }}</td>
                                    <td>{{ @$validation->letter->user->name }}</td>
                                    <td>{{ @$validation->letter->user->position ?? 'Tidak ada data' }}</td>
                                    <td>
                                        @foreach (@$validation->letter->user->managedBy as $manager)
                                        <p class="mb-0">{{ $manager->managerDetail->name }}</p>
                                        @endforeach
                                    </td>
                                    <td>{{ date('D, j F Y H:i', strtotime(@$validation->letter->created_at)) }}</td>
                                    <td>{{ @$validation->letter->participants->count() }} <i class="fa-solid fa-user-group"></i></td>
                                    <td>
                                        {{-- tombol untuk memunculkan modal legalisir --}}
                                        <a href="javascript;;" data-validation="{{ json_encode([ 'id' => @$validation->id ]) }}" data-role="btn-approve" data-bs-toggle="modal" data-bs-target="#formApproveModal" class="text-success me-2 font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Legalisir">Legalisir</a>
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

{{-- modal untuk konfirmasi legalisir --}}
<div class="modal fade" id="formApproveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Legalisir Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    @csrf
                    @method('PUT')
                    <p>Dengan melakukan legalisir, berarti anda sepenuhnya telah mengetahui perihal pengajuan peminjaman unit mobil oleh bawahan anda</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>
@push('after-scripts')

{{-- Script JS untuk inisiasi tabel --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable()
    })
</script>

{{-- script js untuk konfirmasi legalisir --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

    // ambil semua tombol legalisir pada tabel
    const btnApproves = document.querySelectorAll('[data-role=btn-approve]')

    // ambil modal konfirmasi
    const formApproveModal = document.querySelector('#formApproveModal form')
    
    // munculkan modal konfirmasi saat tombol di klik
    btnApproves.forEach(btn => {
        btn.addEventListener('click', () => {

            // ambil id dari legalisir
            const { id } = JSON.parse( btn.dataset.validation )

            // ubah attribute action pada form
            formApproveModal.setAttribute('action', '/deputy/validation/' + id)
        })
    })
})

</script>

@endpush
@endsection