@extends('layouts.soft-ui.app')

@section('content')

{{-- cars --}}
<section class="container-fluid py-4">

    <section class="row gap-4 mb-4">
        {{-- statistik --}}
        <section class="col-lg-7 row gap-3">
            {{-- total --}}
            <div class="col-xl-12 col-sm-6 mb-xl-0">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Unit</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ count( @$cars ) }} Mobil
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
    
            {{-- tersedia --}}
            <div class="col-xl-12 col-sm-6 mb-xl-0">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Unit Tersedia</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ count( @$available ) }} Mobil
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
    
            {{-- terpakai --}}
            <div class="col-xl-12 col-sm-6 mb-xl-0">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Unit Terpakai</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ count( @$used ) }} Mobil
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

        {{-- form --}}
        <section class="col-lg-5 mx-auto">
            <section class="card">
                <section class="text-center pt-4">
                    <h5>Formulir Unit Mobil</h5>
                </section>
                <section class="card-body">
                    <form action="{{ route('admin.car.store') }}" method="POST">
                        @csrf
                        <label>Nama Unit</label>
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="cnth: Daihatsu Sigra" aria-label="Email" aria-describedby="email-addon">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label>Status Unit</label>
                        <div class="mb-3">
                            <select class="form-select" name="status" aria-label="Default select example">
                                <option value="0">Tersedia</option>
                                <option value="1">Digunakan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary col" href="{{ route('admin.car.create') }}">Tambah unit</button>
                    </form>
                </section>
            </section>
        </section>
    </section>

    <section class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Data Unit Mobil</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        {{-- table of car --}}
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Unit</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terkahir Diperbarui</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($cars as $car)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $car->name }}</td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="badge badge-sm {{ $car->status ? 'bg-gradient-danger' : 'bg-gradient-success' }}">{{ $car->status ? 'Digunakan' : 'Tersedia' }}</div>
                                    </td>
                                    <td class="text-center">{{ $car->updated_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        {{-- edit --}}
                                        <a href="javascript;;" data-car="{{ json_encode($car) }}" data-role="btn-edit" data-bs-toggle="modal" data-bs-target="#formEditModal" class="text-success me-2 font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Ubah unit">
                                            Edit
                                        </a>
                                        {{-- delete --}}
                                        <a href="javascript;;" data-car="{{ json_encode($car) }}" data-role="btn-delete" data-bs-toggle="modal" data-bs-target="#formDeleteModal" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Hapus unit">
                                            Hapus
                                        </a>
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
</section>

{{-- modal update --}}
<div class="modal fade" id="formEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    @csrf
                    @method('PUT')
                    <label>Nama Unit</label>
                    <div class="mb-3">
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="cnth: Daihatsu Sigra" aria-label="Email" aria-describedby="email-addon">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label>Status Unit</label>
                    <div class="mb-3">
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option value="0">Tersedia</option>
                            <option value="1">Digunakan</option>
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

{{-- modal delete --}}
<div class="modal fade" id="formDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Unit</h5>
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
    
<script>

window.addEventListener('DOMContentLoaded', () => {

    const btnEdits = document.querySelectorAll('[data-role=btn-edit]')
    const editForm = {
        name: document.querySelector('#formEditModal [name=name]'),
        options: document.querySelectorAll('#formEditModal select option'),
        form: document.querySelector('#formEditModal form'),
    }

    const selected = val => {
        editForm.options.forEach(opt => {
            if ( opt.value == val ) opt.setAttribute('selected', true)
        })
    }

    btnEdits.forEach(btn => {
        btn.addEventListener('click', () => {
            // parse
            const { name, id, status } = JSON.parse( btn.dataset.car )

            editForm.name.value = name
            editForm.form.setAttribute('action', '/admin/car/' + id)
            selected(status)

        })
    })

    const btnDeletes = document.querySelectorAll('[data-role=btn-delete]')
    const deleteForm = {
        form: document.querySelector('#formDeleteModal form'),
        body: document.querySelector('#formDeleteModal p')
    }

    btnDeletes.forEach(btn => {
        btn.addEventListener('click', () => {
            // parse
            const { name, id } = JSON.parse( btn.dataset.car )

            deleteForm.form.setAttribute('action', '/admin/car/' + id)
            deleteForm.body.innerHTML = `Apakah anda yakin ingin menghapus unit <strong>${ name }</strong> dari database ? tindakan ini bersifat permanen`
        })
    })

})


</script>

@endpush

@endsection