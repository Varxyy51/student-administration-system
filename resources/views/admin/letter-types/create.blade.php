@extends('layouts.app')

@section('title', 'Tambah Jenis Surat')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Tambah Jenis Surat Baru</h4>
            <a href="{{ route('admin.letter-types.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger small">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('admin.letter-types.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Surat</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Surat Keterangan Lulus (SKL)" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi / Keterangan</label>
                        <textarea name="description" rows="3" class="form-control" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dokumen Persyaratan (Pisahkan dengan koma)</label>
                        <input type="text" name="requirements_text" class="form-control" value="{{ old('requirements_text') }}" placeholder="Contoh: KTM, Transkrip Nilai, Berita Acara Sidang">
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Aktif (Bisa diajukan mahasiswa)</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Jenis Surat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection