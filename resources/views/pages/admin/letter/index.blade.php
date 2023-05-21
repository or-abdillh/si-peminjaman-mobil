@extends('layouts.soft-ui.app')

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
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pengajuan</p>
                      <h5 class="font-weight-bolder mb-0">
                        {{-- menampilkan hasil query --}}
                        <h6>{{ count(@$letters) }} Surat</h6>
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

        {{-- Hari ini --}}
        <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Hari ini</p>
                      <h5 class="font-weight-bolder mb-0">
                        {{-- menampilkan hasil query --}}
                        <h6>{{ count( @$letterTodays ) }} Surat</h6>
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
                        <h6>{{ count( @$letterAccepteds ) }} Surat</h6>
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

        {{-- Pengajuan diproses --}}
        <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Diproses</p>
                      <h5 class="font-weight-bolder mb-0">
                        {{-- menampilkan hasil query --}}
                        <h6>{{ count(@$letterProcesses) }} Surat</h6>
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

    <section class="row mb-4">
        {{-- tabel pengajuan yang perlu di proses --}}
        <section class="col-lg-8">
            <section class="card">
                <section class="card-header d-flex justify-content-between align-items-center">
                    <section>
                        <h5>Perlu Dikonfirmasi</h5>
                        <small class="text-secondary">Silahkan untuk melakukan konfirmasi pengajuan dibawah ini</small>
                    </section>
                    <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                        <i class="fa-solid text-lg fa-inbox"></i>
                    </section>
                </section>
                <section class="card-body">
                    <div class="table-responsive p-4">
                        {{-- tabel pengguna --}}
                        <table id="table" class="table table-striped align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Pendamping</th>
                                    <th>Atasan</th>
                                    <th>Diajukan</th>
                                    <th>Peserta</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($letterNotConfirmeds as $letter)
                                <tr>
                                    <td>{{ $letter->name }}</td>
                                    <td>{{ $letter->user->name }}</td>
                                    <td>
                                        @foreach (@$letter->user->managedBy as $manager)
                                        <p class="mb-0">{{ $manager->managerDetail->name }}</p>
                                        @endforeach
                                    </td>
                                    <td>{{ date('D, j F Y H:i', strtotime(@$letter->created_at)) }}</td>
                                    <td>{{ @$letter->participants->count() }} <i class="fa-solid fa-user-group"></i></td>
                                    <td class="text-center">
                                        {{-- tombol untuk memunculkan modal menyetujui --}}
                                        <a href="javascript;;" data-letter="{{ json_encode([ 'id' => @$letter->id, 'user_id' => @$letter->user_id ]) }}" data-role="btn-confirm" data-bs-toggle="modal" data-bs-target="#formConfirmModal" class="text-success me-2 font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Konfirmasi">Konfirmasi</a>
                                        {{-- tombol untuk memunculkan modal tolak pengajuan --}}
                                        <a href="javascript;;" data-letter="{{ json_encode(['id' => @$letter->id, 'name' => @$letter->name, 'user' => @$letter->user->name]) }}" data-role="btn-reject" data-bs-toggle="modal" data-bs-target="#formRejectModal" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Tolak">Tolak</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </section>
        </section>

        {{-- daftar unit mobil yang tersedia --}}
        <section class="col-lg-4">
            <section class="card">
                <section class="card-body">
                    <section class="mb-3">
                        <h5>Unit Tersedia</h5>
                        <small class="text-secondary">Berikut unit mobil yang bisa digunakan oleh pemohon</small>
                    </section>
                    <section class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                @foreach (@$cars as $car)
                                <tr>
                                    <td>{{ $car->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </section>
            </section>
        </section>
    </section>
</main>

{{-- modal untuk menyetujui pengajuan --}}
<div class="modal fade" id="formConfirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form method="POST" class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pengajuan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div>
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="user_id">
                  <label>Pilih Unit Mobil</label>
                  <div class="mb-3">
                      <select class="form-select" name="car_id" aria-label="Default select example">
                        @foreach ($cars as $car)
                          <option value="{{ $car->id }}">{{ $car->name }}</option>
                        @endforeach
                      </select>
                  </div>
                  <strong>Catatan</strong>
                  <p>Setelah dikonfirmasi, pengajuan harus menunggu legalisir dari atasan pemohon dan juga deputi</p>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Confirm</button>
          </div>
      </form>
  </div>
</div>

{{-- modal untuk konfirmasi menolak pengajuan --}}
<div class="modal fade" id="formRejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form method="POST" class="modal-content" action="{{ route('admin.letter.feedback.store') }}">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tolak Pengajuan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @csrf
            <input type="hidden" name="letter_id">
            <p></p>
            <div class="mb-2">
              <label>Alasan</label>
              <textarea name="body" cols="30" rows="5" class="form-control" required></textarea>
            </div>
            <small>Anda bisa menambahkan alasan penolakan pada form diatas</small>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Reject</button>
          </div>
      </form>
  </div>
</div>

@endsection

@push('after-scripts')
{{-- Script JS untuk inisiasi tabel --}}
<script type="text/javascript" lang="javascript">
  $(document).ready(function() {
      $('#table').DataTable()
  })
</script>

{{-- script js untuk konfirmasi pengajuan --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

  // ambil semua tombol konfirmasi pada tabel
  const btnConfirms = document.querySelectorAll('[data-role=btn-confirm]')

  // ambil modal konfirmasi pengajuan
  const confirmModal = {
    form: document.querySelector('#formConfirmModal form'),
    user: document.querySelector('#formConfirmModal [name=user_id]')
  }

  // munculkan modal saat tombol konfirmasi di klik
  btnConfirms.forEach(btn => {
    btn.addEventListener('click', () => {

      // ambil data pengajuan
      const { id, user_id } = JSON.parse( btn.dataset.letter )

      // isi otomatis pada form konfirmasi
      confirmModal.form.setAttribute('action', '/admin/letter/' + id)
      confirmModal.user.value = user_id
    })
  })
})

</script>

{{-- script js untuk konfirmasi penolakan --}}
<script type="text/javascript">

window.addEventListener('DOMContentLoaded', () => {

  // ambil semua tombol tolak pada tabel
  const btnRejects = document.querySelectorAll('[data-role=btn-reject]')

  // ambil form penolakan
  const rejectModal = {
    body: document.querySelector('#formRejectModal p'),
    key: document.querySelector('#formRejectModal [name=letter_id]')
  }

  // munculkan modal saat tombol tolak di klik
  btnRejects.forEach(btn => {
    btn.addEventListener('click', () => {

      // ambil data pengajuan yang akan di tolak
      const { id, name, user } = JSON.parse( btn.dataset.letter )

      // isi otomatis modal
      rejectModal.key.value = id
      rejectModal.body.innerHTML = `Yakin untuk melakukan penolakan terhadap pengajuan <strong>${ user }</strong> pada kegiatan <strong>${ name }?</strong>`
    })
  })
})

</script>

@endpush