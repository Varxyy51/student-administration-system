@extends('layouts.app')

@section('title', 'Detail Pengajuan ' . $submission->submission_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Detail Pengajuan: {{ $submission->submission_number }}</h4>
    <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
</div>

@if ($submission->status === 'approved')
    <div class="alert alert-success d-flex justify-content-between align-items-center">
        <span>Selamat! Pengajuan surat Anda telah <strong>DISETUJUI</strong>.</span>
        <a href="{{ route('submissions.print', $submission) }}" target="_blank" class="btn btn-success btn-sm">
            🖨️ Cetak / Download Surat PDF
        </a>
    </div>
@elseif ($submission->status === 'rejected')
    <div class="alert alert-danger">
        Pengajuan surat Anda <strong>DITOLAK</strong>. Silakan periksa catatan admin di bawah ini.
    </div>
@endif

<div class="row g-4">
    <div class="col-md-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">Informasi Surat</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th width="35%">Jenis Surat</th>
                        <td>: {{ $submission->letterType->name }}</td>
                    </tr>
                    <tr>
                        <th>Status Saat Ini</th>
                        <td>: <span class="badge bg-primary text-uppercase">{{ $submission->status }}</span></td>
                    </tr>
                    <tr>
                        <th>Keperluan</th>
                        <td>: {{ $submission->purpose }}</td>
                    </tr>
                    @if ($submission->admin_note)
                        <tr>
                            <th>Catatan Admin</th>
                            <td class="text-danger fw-semibold">: {{ $submission->admin_note }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Dokumen Lampiran</div>
            <ul class="list-group list-group-flush">
                @foreach ($submission->documents as $doc)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $doc->original_name }}</span>
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Lihat File
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Riwayat Status (Tracking)</div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @foreach ($submission->histories as $history)
                        <li class="border-start border-2 border-primary ps-3 pb-3">
                            <div class="small text-muted">{{ $history->created_at->format('d M Y, H:i') }}</div>
                            <div class="fw-bold text-uppercase">{{ $history->status }}</div>
                            <div class="small">{{ $history->note }}</div>
                            <div class="small text-muted">Oleh: {{ $history->actor->name ?? 'Sistem' }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection