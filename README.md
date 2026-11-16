# Sistem Administrasi Surat Mahasiswa (SI-SURAT KAMPUS)

Aplikasi web berbasis **Laravel** untuk digitalisasi layanan pengajuan, verifikasi, pelacakan status (*tracking*), hingga penerbitan surat akademik mahasiswa secara terintegrasi antara Mahasiswa dan Admin Akademik.

## Fitur Utama

### Role Mahasiswa
- **Autentikasi & Registrasi Akademik**: Pendaftaran akun lengkap dengan NIM, Program Studi, Fakultas, dan Angkatan.
- **Pengajuan Surat Online**: Pemilihan jenis surat dinamis dengan informasi syarat dokumen otomatis.
- **Upload Multi-Dokumen**: Unggah beberapa file persyaratan sekaligus (PDF, JPG, PNG).
- **Tracking Riwayat Pengajuan**: Pantau progres status (`Pending`, `Approved`, `Rejected`) beserta log waktu dan catatan pemeriksa.
- **Cetak Surat Resmi**: Unduh/cetak surat berkop resmi secara mandiri setelah pengajuan disetujui.
- **Manajemen Profil**: Pembaruan kontak, alamat domisili, dan penggantian password.

### Role Admin Akademik
- **Dashboard Statistik**: Ringkasan jumlah total pengajuan, menunggu verifikasi, disetujui, dan ditolak dengan filter status cepat.
- **Verifikasi & Validasi Dokumen**: Pratinjau berkas persyaratan mahasiswa serta persetujuan (`Approve`) atau penolakan (`Reject`) disertai catatan.
- **CRUD Master Jenis Surat**: Tambah, ubah, aktif/nonaktifkan, dan hapus jenis surat beserta daftar persyaratannya.

## Teknologi yang Digunakan
- **Backend**: PHP 8.3, Laravel Framework
- **Database**: SQLite / MySQL
- **Frontend**: Blade Templating, Bootstrap 5
- **Server Lokal**: Laragon

## Instalasi & Menjalankan Proyek

1. **Clone repository**
   ```bash
   git clone [https://github.com/Varxyy51/student-administration-system.git](https://github.com/Varxyy51/student-administration-system.git)
   cd student-administration-system