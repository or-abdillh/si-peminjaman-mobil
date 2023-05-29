@extends('layouts.soft-ui.app')

@section('content')
<main class="container-fluid">
    {{-- statistik --}}
    <section class="row mb-4">
        {{-- total semua surat yang diajukan --}}
        <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total</p>
                      <h5 class="font-weight-bolder mb-0">
                        {{-- menampilkan hasil query --}}
                        <h6>{{ count( @$letters ) }} Surat</h6>
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

        {{-- total surat yang disetujui --}}
        <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Disetujui</p>
                      <h5 class="font-weight-bolder mb-0">
                        {{-- menampilkan hasil query --}}
                        <h6>{{ $accepteds }} Surat</h6>
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

        {{-- total surat yang ditolak --}}
        <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Ditolak</p>
                      <h5 class="font-weight-bolder mb-0">
                        {{-- menampilkan hasil query --}}
                        <h6>{{ $rejecteds }} Surat</h6>
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

        {{-- total surat yang masih di proses --}}
        <section class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Diproses</p>
                      <h5 class="font-weight-bolder mb-0">
                        {{-- menampilkan hasil query --}}
                        <h6>{{ $processes }} Surat</h6>
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

    {{-- data seluruh surat --}}
    <section class="row mb-4">
        {{-- tabel --}}
        <section class="col">
            <section class="card">
                <section class="card-header d-flex justify-content-between align-items-center">
                    <section>
                        <h5>Semua surat pengajuan</h5>
                        <small class="text-secondary">Berikut adalah daftar semua surat pengajuan yang pernah masuk</small>
                    </section>
                    <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                        <i class="fa-solid text-lg fa-inbox"></i>
                    </section>
                </section>
                <section class="card-body">
                    <section class="table-responsive">
                        <table id="table" class="table table-striped align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Pemohon</th>
                                    <th>Tujuan</th>
                                    <th>Peserta</th>
                                    <th>Diajukan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($letters as $letter)
                                <tr>
                                    <td>{{ $letter->name }}</td>
                                    <td>{{ $letter?->user?->name }}</td>
                                    <td>{{ $letter->destination_place }}</td>
                                    <td class="text-center">{{ $letter?->participants?->count() }} <i class="fa-solid fa-user-group"></i></td>
                                    <td>{{ date('D, j F Y H:i', strtotime($letter->created_at)) }}</td>
                                    <td class="align-middle text-center text-sm">
                                        @if (is_null( $letter->status ))
                                            <div class="badge badge-sm bg-info">Diproses</div>
                                        @elseif ($letter->status)
                                            <div class="badge badge-sm bg-success">Disetujui</div>
                                        @else
                                            <div class="badge badge-sm bg-danger">Ditolak</div>
                                        @endif
                                    </td>
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
@endsection

@push('after-scripts')
{{-- Script JS untuk inisiasi tabel --}}
<script type="text/javascript" lang="javascript">
    $(document).ready(function() {
        $('#table').DataTable()
    })
</script>  
@endpush