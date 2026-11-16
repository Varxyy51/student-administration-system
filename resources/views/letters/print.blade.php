<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - {{ $submission->submission_number }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 40px 60px; color: #000; line-height: 1.6; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 25px; }
        .kop h2, .kop h3, .kop p { margin: 2px 0; }
        .judul { text-align: center; margin-bottom: 25px; }
        .judul h4 { text-decoration: underline; margin-bottom: 2px; text-transform: uppercase; }
        .tabel-data { margin: 15px 0 20px 30px; }
        .tabel-data td { padding: 4px 10px; vertical-align: top; }
        .ttd { width: 280px; float: right; margin-top: 40px; text-align: left; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 8px 16px; cursor: pointer;">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="kop">
        <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h3>
        <h2>FAKULTAS ILMU KOMPUTER</h2>
        <p style="font-size: 13px;">Jl. Raya Kampus Akademik No. 1, Tangerang Selatan • Telp. (021) 7412566</p>
    </div>

    <div class="judul">
        <h4>{{ $submission->letterType->name }}</h4>
        <span>Nomor: {{ $submission->submission_number }}/AKD/{{ now()->format('Y') }}</span>
    </div>

    <p>Yang bertanda tangan di bawah ini, Bagian Administrasi Akademik Fakultas Ilmu Komputer menerangkan bahwa:</p>

    <table class="tabel-data">
        <tr>
            <td width="160">Nama Lengkap</td>
            <td>: <strong>{{ $submission->user->name }}</strong></td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>: {{ $submission->user->studentProfile->nim ?? '-' }}</td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td>: {{ $submission->user->studentProfile->program_studi ?? '-' }}</td>
        </tr>
        <tr>
            <td>Fakultas</td>
            <td>: {{ $submission->user->studentProfile->fakultas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Angkatan</td>
            <td>: {{ $submission->user->studentProfile->angkatan ?? '-' }}</td>
        </tr>
    </table>

    <p>Adalah benar mahasiswa aktif yang terdaftar pada semester berjalan. Surat keterangan ini diterbitkan untuk keperluan: <strong>{{ $submission->purpose }}</strong>.</p>

    <p>Demikian surat ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <div class="ttd">
        <p>Tangerang Selatan, {{ ($submission->reviewed_at ?? now())->translatedFormat('d F Y') }}<br>
        Kepala Bagian Administrasi Akademik,</p>
        <br><br><br>
        <p><strong><u>{{ $submission->reviewer->name ?? 'Admin Akademik' }}</u></strong><br>
        NIP. 198504122010121001</p>
    </div>
</body>
</html>