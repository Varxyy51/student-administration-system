<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Administrasi Surat Mahasiswa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SI-SURAT KAMPUS</a>
           @auth
                <div class="d-flex align-items-center gap-3 text-white">
                    <span class="small">{{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})</span>
                    @if (Auth::user()->role === 'student')
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-sm btn-light text-primary fw-semibold">
                            Profil Saya
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>