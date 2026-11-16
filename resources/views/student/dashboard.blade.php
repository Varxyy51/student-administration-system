@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Dashboard Mahasiswa</h4>
        <small class="text-muted">
            {{ Auth::user()->name }} • NIM: {{ Auth::user()->studentProfile->nim ?? '-' }} • {{ Auth::user()->studentProfile->program_studi ?? '-' }}
        </small>
    </div>
    <a href="{{ route('student.submissions.create') }}" class="btn btn-primary">
        + Ajukan Surat Baru
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0">Riwayat Pengajuan Surat Saya</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Pengajuan</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal Ajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->submission_number }}</td>
                            <td>{{ $item->letterType->name }}</td>
                            <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @php
                                    $badge = match($item->status) {
                                        'pending' => 'warning text-dark',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'secondary'
                                    };
                                    $label = match($item->status) {
                                        'pending' => 'Menunggu Verifikasi',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        default => ucfirst($item->status)
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                            </td>
                            <td>
                                <a href="{{ route('student.submissions.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                    Detail & Tracking
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada pengajuan surat. Klik <strong>+ Ajukan Surat Baru</strong> untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection