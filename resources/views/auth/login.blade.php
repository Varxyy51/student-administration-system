@extends('layouts.app')

@section('title', 'Login - Sistem Administrasi Mahasiswa')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="fw-bold text-center mb-1">Masuk ke Sistem</h4>
                <p class="text-muted text-center small mb-4">Layanan Pengajuan Surat Akademik Mahasiswa</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@student.ac.id" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <hr class="my-4">
                <p class="text-center small mb-0">
                    Belum punya akun mahasiswa? <a href="{{ route('register') }}">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection