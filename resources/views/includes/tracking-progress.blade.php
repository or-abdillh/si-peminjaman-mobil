@push('before-styles')
    <link rel="stylesheet" href="{{ asset('css/tracking-progress.css') }}">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
@endpush

<section class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
    {{-- diproses --}}
    <div class="step completed">
        <div class="step-icon-wrap">
            <div class="step-icon"><i class="fa-solid fa-inbox"></i></div>
        </div>
        <h4 class="step-title">Pengajuan Diproses</h4>
    </div>

    {{-- disetujui admin --}}
    <div class="step {{ $letter->car_id > 0 ? 'completed' : '' }}">
        <div class="step-icon-wrap">
            <div class="step-icon"><i class="fa-solid fa-circle-check"></i></div>
        </div>
        <h4 class="step-title">{{ $letter->car_id > 0 ? 'Disetujui Admin' : 'Menunggu Persetujuan Admin' }}</h4>
    </div>

    {{-- legalisir --}}
    <div
        class="step {{ $letter?->validation?->deputy_signature > 0 || $letter?->validation?->manager_signature > 0 ? 'completed' : '' }}">
        <div class="step-icon-wrap">
            <div class="step-icon"><i class="fa-solid fa-file-signature"></i></div>
        </div>
        <h4 class="step-title">
            @if (is_null($letter?->validation?->deputy_signature) && is_null($letter?->validation?->manager_signature))
                Menunggu Legalisir Deputi dan Atasan
            @elseif($letter?->validation?->deputy_signature > 0 && $letter?->validation?->manager_signature)
                Telah Dilegalisir
            @else
                {{ is_null($letter?->validation?->deputy_signature) ? 'Menunggu Legalisir Deputi' : '' }}
                {{ is_null($letter?->validation?->manager_signature) ? 'Menunggu Legalisir Atasan' : '' }}
            @endif
        </h4>
    </div>

    {{-- surat siap --}}
    <div class="step {{ isset($letter->status) && $letter->status == true ? 'completed' : '' }}">
        <div class="step-icon-wrap">
            <div class="step-icon"><i class="fa-solid fa-envelope-circle-check"></i></div>
        </div>
        <h4 class="step-title">Surat Siap Digunakan</h4>
    </div>
</section>
