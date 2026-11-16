@extends('layouts.app')

@section('title', 'Profil Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Pengaturan Akun & Profil</h4>
        <small class="text-muted">Perbarui kontak atau keamanan akun Anda</small>
    </div>
    <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-outline-secondary">← Kembali ke Dashboard</a>
</div>

<div class="row g-4">
    <!-- Form Data Profil -->
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Biodata Akademik & Kontak</div>
            <div class="card-body p-4">
                @if (session('success_profile'))
                    <div class="alert alert-success small">{{ session('success_profile') }}</div>
                @endif

                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">NIM (Tidak dapat diubah)</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->studentProfile->nim ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Email</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Program Studi</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->studentProfile->program_studi ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Angkatan</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->studentProfile->angkatan ?? '-' }}" readonly>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">No. HP / WhatsApp</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->studentProfile->phone ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat Domisili</label>
                            <textarea name="address" rows="3" class="form-control">{{ old('address', $user->studentProfile->address ?? '') }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan Profil</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Ganti Password -->
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Ganti Password</div>
            <div class="card-body p-4">
                @if (session('success_password'))
                    <div class="alert alert-success small">{{ session('success_password') }}</div>
                @endif

                @if ($errors->has('current_password') || $errors->has('password'))
                    <div class="alert alert-danger small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('student.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-outline-danger w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection