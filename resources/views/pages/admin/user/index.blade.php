@extends('layouts.soft-ui.app')

@section('content')

<main class="container-fluid py-4">

    {{-- menampilkan data statistik pengguna --}}
    <section class="row mb-4">
        <section class="col-lg-7 row gap-1">
            
            {{-- semua pengguna --}}
            <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pengguna</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- Melakukan perhitungan jumlah record yang didapat --}}
                                        {{ count( @$users ) + count( @$deputies ) + count( @$managers ) }} Pengguna
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

            {{-- pengguna biasa --}}
            <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pengguna Biasa</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- Melakukan perhitungan jumlah record yang didapat --}}
                                        {{ count( @$users ) }} Pengguna
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
    
            {{-- akun deputy --}}
            <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Deputi</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- Melakukan perhitungan jumlah record yang didapat --}}
                                        {{ count( @$deputies ) }} Pengguna
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
    
            {{-- akun manager --}}
            <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Manager</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- Melakukan perhitungan jumlah record yang didapat --}}
                                        {{ count( @$managers ) }} Pengguna
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

        {{-- formulir tambah pengguna --}}
        <section class="col-lg-5 mx-auto">
            <section class="card">
                <section class="text-center pt-4">
                    <h5>Formulir Pengguna</h5>
                </section>
                <section class="card-body">
                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf
                        <label>Nama</label>
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="cnth: Novi Marliana" aria-label="Email" aria-describedby="email-addon">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label>Email</label>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="cnth: novi-marliana1112@gmail.com" aria-label="Email" aria-describedby="email-addon">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label>Password Default</label>
                        <div class="mb-3">
                            <input name="password" type="text" value="12345678" readonly class="form-control @error('password') is-invalid @enderror" required placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>

                        <label>Tipe Pengguna</label>
                        <div class="mb-3">
                            <select class="form-select" name="role" aria-label="Default select example">
                                {{-- render jenis role yang ada ke dalam opsi --}}
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary col" href="{{ route('admin.car.create') }}">Tambah pengguna</button>
                    </form>
                </section>
            </section>
        </section>
    </section>

    {{-- menampilkan data seluruh pengguna dalam bentuk table --}}
    <section class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Data Pengguna Terdaftar</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        {{-- tabel pengguna --}}
                        <table id="table" class="table table-striped align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Tipe Pengguna</th>
                                    <th>Terdaftar sejak</th>
                                    <th>Terakhir diperbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$users->concat(@$managers)->concat(@$deputies) as $user)
                                <tr>
                                    <td>{{ @$user->name }}</td>
                                    <td>{{ @$user->email }}</td>
                                    <td class="text-center">{{ @$user->roles->first()->name }}</td>
                                    <td>{{ date('D, j F Y H:i', strtotime(@$user->created_at)) }}</td>
                                    <td>{{ @$user->updated_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        {{-- tombol untuk memunculkan modal edit pengguna --}}
                                        <a href="javascript;;" data-user="{{ json_encode([ 'id' => @$user->id, 'name' => @$user->name, 'email' => @$user->email, 'role' => @$user->roles->first()->name ]) }}" data-role="btn-edit" data-bs-toggle="modal" data-bs-target="#formEditModal" class="text-success me-2 font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Ubah unit">Edit</a>
                                        {{-- tombol untuk memunculkan modal hapus pengguna --}}
                                        <a href="javascript;;" data-user="{{ json_encode(['id' => @$user->id, 'name' => @$user->name]) }}" data-role="btn-delete" data-bs-toggle="modal" data-bs-target="#formDeleteModal" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Hapus unit">Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- modal form edit  --}}
<div class="modal fade" id="formEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    @csrf
                    @method('PUT')
                    <label>Nama</label>
                    <div class="mb-3">
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="cnth: Novi Marliana" aria-label="Email" aria-describedby="email-addon">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label>Email</label>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="cnth: novi-marliana1112@gmail.com" aria-label="Email" aria-describedby="email-addon">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label>Tipe Pengguna</label>
                    <div class="mb-3">
                        <select class="form-select" name="role" aria-label="Default select example">
                            {{-- render jenis role yang ada ke dalam opsi --}}
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

{{-- modal hapus pengguna --}}
<div class="modal fade" id="formDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    @csrf
                    @method('DELETE')
                    <p></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Delete</button>
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

{{-- Script JS untuk ubah data pengguna --}}
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', () => {

    // Ambil semua tombol edit pada tabel
    const btnEdits = document.querySelectorAll('[data-role=btn-edit]')

    // Ambil field dan body formulir edit pengguna pada modal
    const editModal = {
        form: document.querySelector('#formEditModal form'),
        name: document.querySelector('#formEditModal [name=name]'),
        email: document.querySelector('#formEditModal [name=email]'),
        options: document.querySelectorAll('#formEditModal option')
    }

    // Munculkan modal saat tombol edit pada tabel di klik
    btnEdits.forEach(btn => {

        btn.addEventListener('click', () => {

            // Ambil data pengguna melalui data-user attribute pada tombol edit
            const { id, name, email, role } = JSON.parse( btn.dataset.user )
    
            // Isi otomatis pada modal formulir edit pengguna sesuai dengan yang akan di ubah
            editModal.name.value = name
            editModal.email.value = email
    
            // Pilih otomatis option pada inputan tipe pengguna berdasarkan role pengguna yang akan di ubah
            editModal.options.forEach(option => {
                if ( option.value == role ) option.setAttribute('selected', true)
            })
    
            // Ubah action attribute pada formulir edit pengguna menjadi /admin/user/id berdasarkan id pengguna yang akan di edit
            editModal.form.setAttribute('action', '/admin/user/' + id)
        })
    })
})
</script>

{{-- Script JS untuk hapus pengguna --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

    // Ambil semua tombol 
    const btnDeletes = document.querySelectorAll('[data-role=btn-delete]')

    // Ambil form pada modal hapus pengguna
    const deleteModal = {
        form: document.querySelector('#formDeleteModal form'),
        body: document.querySelector('#formDeleteModal p')
    }

    // Munculkan modal hapus pengguna saat tombol delete pada tabel di klik
    btnDeletes.forEach(btn => {
        btn.addEventListener('click', () => {
            // Ambil data pengguna pada data-user attribute di tombol delete
            const { id, name } = JSON.parse( btn.dataset.user )

            // Ubah action attribute pada form hapus pengguna menjadi /admin/user/id berdasarkan id pengguna yang akan di hapus
            deleteModal.form.setAttribute('action', '/admin/user/' + id)

            // Isi otomatis body pada form hapus pengguna
            deleteModal.body.innerHTML = `Apakah anda yakin ingin menghapus <strong>${ name }</strong> dari data pengguna ? ini bersifat permanen`
        })
    })
})

</script>

@endpush

@endsection