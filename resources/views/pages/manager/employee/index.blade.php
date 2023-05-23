@extends('layouts.soft-ui.app')

@section('content')

<main class="container-fluid py-4">

    <section class="row mb-4">

        {{-- statistik --}}
        <section class="col row">
            {{-- seluruh karyawan --}}
            <div class="col-xl-6 col-sm-6 mb-xl-0">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Keseluruhan Karyawan</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ count(@$otherEmployees) + count( @$employees ) }} Karyawan
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

            {{-- jumlah bawahan --}}
            <div class="col-xl-6 col-sm-6 mb-xl-0">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Bawahan Anda</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- menampilkan jumlah data berdasarkan hasil query --}}
                                        {{ count( @$employees ) }} Karyawan
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

    </section>

    <section class="row mb-4">
        {{-- menampilan data karyawan yang bukan bawahan --}}
        <section class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-2">
                    <h5 class="mb-1">Data Bukan Bawahan</h5>
                    <small class="text-secondary">Menampilkan semua data karyawan yang bukan berstatus bawahan anda</small>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <table id="table" class="table table-striped align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($otherEmployees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>
                                        {{-- tombol untuk menambahkan karyawan sebagai bawahan --}}
                                        <a href="javascript;;" data-employee="{{ json_encode(['id' => @$employee->id, 'name' => @$employee->name]) }}" data-role="btn-add" data-bs-toggle="modal" data-bs-target="#addFormModal" class="text-info font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Jadikan bawahan">Tambah</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        {{-- menampilkan data bawahan ke dalam tabel --}}
        <section class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-2">
                    <h5 class="mb-1">Data Bawahan</h5>
                    <small class="text-secondary">Menampilkan semua data karyawan yang berada di bawah tanggung jawab anda</small>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        {{-- table of car --}}
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $employee->employeeDetail->name }}</td>
                                    <td class="text-center">
                                        {{-- tombol hapus data bawahan --}}
                                        <a href="javascript;;" data-employee="{{ json_encode(['id' => @$employee->id, 'name' => @$employee->employeeDetail->name]) }}" data-role="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteFormModal" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Hapus bawahan">Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>

</main>

{{-- modal tambah bawahan --}}
<div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('manager.employee.store') }}" class="modal-content">
            @csrf
            @method('POST')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Jadikan Bawahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="hidden" name="manager_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="user_id" value="">
                    <p></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- modal hapus bawahan --}}
<div class="modal fade" id="deleteFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Bawahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <p></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
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

{{-- script js untuk tambah bawahan --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

    // ambil semua tombol tambah bawahan
    const btnAdds = document.querySelectorAll('[data-role=btn-add]')

    // ambil form tambah bawahan
    const addEmployee = {
        body: document.querySelector('#addFormModal p'),
        user: document.querySelector('#addFormModal [name=user_id]')
    }

    // munculkan modal saat tombol add di klik pada tabel
    btnAdds.forEach(btn => {
      btn.addEventListener('click', () => {

        // ambil data calon bawahan baru
        const { id, name } = JSON.parse( btn.dataset.employee )

        // isi otomatis form
        addEmployee.user.value = id
        addEmployee.body.innerHTML = `Apakah anda ingin menjadikan <strong>${ name }</strong> sebagai bawahan anda ?`
      })  
    })
})

</script>

{{-- script js untuk hapus data bawahan --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

    /// ambil semua tombol hapus bawahan pada tabel
    const btnDeletes = document.querySelectorAll('[data-role=btn-delete]')

    // ambil form hapus bawahan
    const deleteEmployee = {
        form: document.querySelector('#deleteFormModal form'),
        body: document.querySelector('#deleteFormModal p')
    }

    // munculkan modal saat tombol hapus bawahan di klik pada tabel
    btnDeletes.forEach(btn => {
        btn.addEventListener('click', () => {

            // ambil data bawahan yang akan dihapus
            const { id, name } = JSON.parse( btn.dataset.employee )

            // isi otomatis form
            deleteEmployee.form.setAttribute('action', '/manager/employee/' + id)
            deleteEmployee.body.innerHTML = `Anda yakin untuk menghapus <strong>${ name }</strong> sebagai bawahan anda? tindakan ini tidak akan menghapus data pengguna`
        })
    })
})

</script>

@endpush

@endsection