@extends('layouts.app')

@section('title', 'Kelola Jenis Surat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Master Jenis Surat</h4>
        <small class="text-muted">Atur jenis surat akademik beserta dokumen persyaratannya</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Dashboard</a>
        <a href="{{ route('admin.letter-types.create') }}" class="btn btn-primary">+ Tambah Jenis Surat</a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Jenis Surat</th>
                        <th>Persyaratan Dokumen</th>
                        <th>Status</th>
                        <th>Total Ajuan</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($letterTypes as $type)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $type->name }}</div>
                                <small class="text-muted">{{ Str::limit($type->description, 70) }}</small>
                            </td>
                            <td>
                                @forelse ($type->requirements ?? [] as $req)
                                    <span class="badge bg-light text-dark border">{{ $req }}</span>
                                @empty
                                    <span class="text-muted small">-</span>
                                @endforelse
                            </td>
                            <td>
                                @if ($type->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $type->submissions_count }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.letter-types.edit', $type) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.letter-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Hapus jenis surat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data jenis surat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection