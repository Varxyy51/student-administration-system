@extends('layouts.app')

@section('title', 'Dashboard Admin Akademik')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Dashboard Admin Akademik</h4>
        <small class="text-muted">Kelola dan verifikasi pengajuan surat mahasiswa</small>
    </div>
    <a href="{{ route('admin.letter-types.index') }}" class="btn btn-outline-primary">
        ⚙️ Kelola Jenis Surat
    </a>
</div>

<!-- Ringkasan Statistik -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-body">
                    <div class="text-muted small">Total Pengajuan</div>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body">
                    <div class="text-warning-emphasis small fw-semibold">Menunggu Verifikasi</div>
                    <h3 class="fw-bold text-warning-emphasis mb-0">{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard', ['status' => 'approved']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body">
                    <div class="text-success small fw-semibold">Disetujui</div>
                    <h3 class="fw-bold text-success mb-0">{{ $stats['approved'] }}</h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard', ['status' => 'rejected']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
                <div class="card-body">
                    <div class="text-danger small fw-semibold">Ditolak</div>
                    <h3 class="fw-bold text-danger mb-0">{{ $stats['rejected'] }}</h3>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Tabel Daftar Pengajuan -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">
            Daftar Pengajuan Surat {{ $status ? '(' . strtoupper($status) . ')' : '' }}
        </h6>
        @if ($status)
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">Reset Filter</a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Pengajuan</th>
                        <th>Mahasiswa</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->submission_number }}</td>
                            <td>
                                <div class="fw-semibold">{{ $item->user->name }}</div>
                                <small class="text-muted">NIM: {{ $item->user->studentProfile->nim ?? '-' }}</small>
                            </td>
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
                                @endphp
                                <span class="badge bg-{{ $badge }} text-uppercase">{{ $item->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.submissions.show', $item) }}" class="btn btn-sm btn-primary">
                                    Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data pengajuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection