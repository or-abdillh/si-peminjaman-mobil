@extends('layouts.print')

@section('content')
<header>
    {{-- logo YHC --}}
    <section class="header--logo">
        <img src="{{ asset('images/yayasan-hasnur-centre-logo.png') }}" alt="Yayasan Hasnur Centre">
    </section>
    <section class="header--title">
        <p>SMP SMA GLOBAL ISLAMIC BOARDING SCHOOL</p>
        <h1>VEHICLE REQUEST FORM</h1>
    </section>
</header>

{{-- detail surat --}}
<section class="detail">
    {{-- waktu --}}
    <section class="detail--wrapper">
        <section class="detail--title">
            <section>
                <p>Waktu</p>
                <em>Time</em>
            </section>
            :
        </section>
        <section class="detail--content">
            <p>Hari: {{ date('l', strtotime($letter->start_time)) }},</p>
            <p>Tanggal: {{ date('d F Y', strtotime($letter->start_time)) }},</p>
            <p>Mulai Pukul: {{ date('H:i', strtotime($letter->start_time)) }}</p>
            <p>sd: {{ date('H:i', strtotime($letter->finish_time)) }}</p>
        </section>
    </section>
    {{-- tempat tujuan --}}
    <section class="detail--wrapper">
        <section class="detail--title">
            <section>
                <p>Tempat Tujuan</p>
                <em>Destintation</em>
            </section>
            :
        </section>
        <section class="detail--content">
            <p>{{ $letter->destination_place }}</p>
        </section>
    </section>
    {{-- tempat jemput --}}
    <section class="detail--wrapper">
        <section class="detail--title">
            <section>
                <p>Tempat Jemput</p>
                <em>Pickup Point</em>
            </section>
            :
        </section>
        <section class="column">
            <small>(Lobby depan atau belakang GP /Lobby Dormitory /Area jualan cafe /dll...)</small>
            <small>{{ $letter->pickup_place }}</small>
        </section>
    </section>
    {{-- kegiatan --}}
    <section class="detail--wrapper">
        <section class="detail--title">
            <section>
                <p>Kegiatan</p>
                <em>Activity</em>
            </section>
            :
        </section>
        <section class="detail--content">
            <p>{{ $letter->name }}</p>
        </section>
    </section>
</section>

{{-- estimasi kegiatan --}}
<section class="estimation">
    <table class="table" >
        <thead>
            <tr>
                <th>Estimasi Waktu</th>
                <th>Estimasi Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($letter->activities as $activity)
            <tr>
                <td>{{ $activity->estimation_time }}</td>
                <td>{{ $activity->estimation }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

{{-- jumlah peserta --}}
<section class="participant">
        <section class="participant--title">
            Nama & jumlah peserta = L {{ $participantMales }} /P {{ $participantFemales }}
        </section>
    <section class="participant--list">
        {{-- render peserta yang terdaftar --}}
        @foreach ($participants as $participant)
        <section class="participant--list--column">
            <small>{{ $loop->iteration }}. {{ $participant->name }}</small>
            <small>{{ $participant->gender === 'Pria' ? 'L' : 'P' }}</small>
        </section>
        @endforeach
        {{-- render list kosong  --}}
        @for ($i = count(@$participants); $i < @$emptyColumns + count(@$participants); $i++)
        <section class="participant--list--column">
            <small>{{ $i + 1 }}. </small>
            <small>L/P</small>
        </section>
        @endfor
    </section>
</section>

{{-- informasi pemohon --}}
<section class="applicant">
    {{-- nama --}}
    <section class="applicant--wrapper">
        <section class="applicant--title">
            Nama pendamping*
        </section>
        <section class="applicant--content">
            : {{ $letter->user->name }}
        </section>
    </section>

    {{-- nomor telepon --}}
    <section class="applicant--wrapper">
        <section class="applicant--title">
            No. HP
        </section>
        <section class="applicant--content">
            : 08979688757
        </section>
    </section>

</section>

{{-- catatan hari ditetapkan --}}
<section class="information">
    <section class="information--note">
        *) Guru/Asatidz/Staff yang mendampingi siswa (ikut serta dalam kegiatan)
    </section>
    <section class="information--date">
        Alalak, {{ date('d F Y', strtotime($letter->validation->updated_at)) }}
    </section>
</section>

@if ($signatures)
{{-- tanda tangan --}}
<section class="signature">
    {{-- Deputy --}}
    <section class="signature--wrapper">
        <section class="header">Mengetahui</section>
        <main>
            <img width="200" src="{{ asset('storage/signatures/' . $letter?->validation?->deputySignature?->image) }}" alt="">
            <p>( {{ $letter?->validation?->deputySignature?->user?->name }} )</p>
        </main>
        <footer>Deputy</footer>
    </section>

    {{-- Manager --}}
    <section class="signature--wrapper">
        <section class="header">Disetujui</section>
        <main>
            <img width="200" src="{{ asset('storage/signatures/' . $letter?->validation?->managerSignature?->image) }}" alt="">
            <p>( {{ $letter?->validation?->managerSignature?->user?->name ?? 'Tidak ada data' }} )</p>
        </main>
        <footer>Atasan Pemohon</footer>
    </section>

    {{-- User --}}
    <section class="signature--wrapper">
        <section class="header">User</section>
        <main>
            <img src="{{ asset('storage/signatures/' . $letter?->validation?->applicantSignature?->image) }}" alt="">
            <p>( {{ $letter?->validation?->applicantSignature?->user?->name ?? 'Tidak ada data' }} )</p>
        </main>
        <footer>Nama & Tandatangan</footer>
    </section>
</section>
@endif
@endsection