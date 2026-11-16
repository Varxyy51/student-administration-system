@extends('layouts.app')

@section('title', 'Verifikasi Pengajuan ' . $submission->submission_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Verifikasi Pengajuan: {{ $submission->submission_number }}</h4>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger small">{{ $errors->first() }}</div>
@endif

<div class="row g-4">
    <div class="col-md-7">
        <!-- Data Mahasiswa & Surat -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">Data Mahasiswa & Permohonan</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th width="35%">Nama Mahasiswa</th>
                        <td>: {{ $submission->user->name }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>: {{ $submission->user->studentProfile->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Program Studi / Fakultas</th>
                        <td>: {{ $submission->user->studentProfile->program_studi ?? '-' }} / {{ $submission->user->studentProfile->fakultas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Surat</th>
                        <td>: <strong>{{ $submission->letterType->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Keperluan</th>
                        <td>: {{ $submission->purpose }}</td>
                    </tr>
                    <tr>
                        <th>Status Saat Ini</th>
                        <td>: <span class="badge bg-primary text-uppercase">{{ $submission->status }}</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Lampiran Dokumen -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Dokumen Persyaratan Mahasiswa</div>
            <ul class="list-group list-group-flush">
                @foreach ($submission->documents as $doc)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $doc->original_name }}</span>
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Buka / Cek Dokumen
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-md-5">
        <!-- Panel Keputusan Admin -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">Tindakan Verifikasi Admin</div>
            <div class="card-body">
                <form action="{{ route('admin.submissions.update-status', $submission) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keputusan</label>
                        <select name="status" class="form-select" required>
                            <option value="approved" {{ $submission->status === 'approved' ? 'selected' : '' }}>Setujui (Approve)</option>
                            <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Tolak (Reject)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan / Alasan (Wajib jika ditolak)</label>
                        <textarea name="admin_note" rows="3" class="form-control" placeholder="Tulis catatan untuk mahasiswa...">{{ old('admin_note', $submission->admin_note) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Simpan Keputusan</button>
                </form>

                @if ($submission->status === 'approved')
                    <hr>
                    <a href="{{ route('submissions.print', $submission) }}" target="_blank" class="btn btn-outline-dark w-100">
                        🖨️ Cetak / Preview Surat Resmi
                    </a>
                @endif
            </div>
        </div>

        <!-- Riwayat -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Riwayat Proses</div>
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