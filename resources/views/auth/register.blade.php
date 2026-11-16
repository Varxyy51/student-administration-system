@extends('layouts.app')

@section('title', 'Registrasi Mahasiswa')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="fw-bold text-center mb-1">Registrasi Akun Mahasiswa</h4>
                <p class="text-muted text-center small mb-4">Lengkapi data akademik untuk mulai mengajukan surat</p>

                @if ($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Studi</label>
                            <input type="text" name="program_studi" class="form-control" value="{{ old('program_studi') }}" placeholder="Contoh: Sistem Informasi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fakultas</label>
                            <input type="text" name="fakultas" class="form-control" value="{{ old('fakultas') }}" placeholder="Contoh: Ilmu Komputer" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Angkatan</label>
                            <input type="text" name="angkatan" class="form-control" value="{{ old('angkatan') }}" placeholder="Contoh: 2023" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. HP / WhatsApp</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Kampus / Pribadi</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-4">Daftar Sekarang</button>
                </form>

                <hr class="my-4">
                <p class="text-center small mb-0">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection