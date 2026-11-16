<?php

namespace Database\Seeders;

use App\Models\LetterType;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Akademik
        User::updateOrCreate(
            ['email' => 'admin@kampus.ac.id'],
            [
                'name' => 'Admin Akademik',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Mahasiswa Contoh
        $student = User::updateOrCreate(
            ['email' => 'farhan@student.ac.id'],
            [
                'name' => 'Farhan Munfaridz',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]
        );

        StudentProfile::updateOrCreate(
            ['user_id' => $student->id],
            [
                'nim' => '231011700975',
                'program_studi' => 'Sistem Informasi',
                'fakultas' => 'Ilmu Komputer',
                'angkatan' => '2023',
                'phone' => '081234567890',
                'address' => 'Permata Pamulang, Tangerang Selatan',
            ]
        );

        // 3. Data Master Jenis Surat
        $letters = [
            [
                'name' => 'Surat Keterangan Aktif Kuliah',
                'slug' => 'surat-keterangan-aktif-kuliah',
                'description' => 'Surat resmi yang menyatakan mahasiswa masih aktif mengikuti perkuliahan pada semester berjalan.',
                'requirements' => ['Kartu Tanda Mahasiswa (KTM)', 'Bukti Pembayaran UKT Terakhir'],
                'is_active' => true,
            ],
            [
                'name' => 'Surat Pengantar Magang / Kerja Praktik',
                'slug' => 'surat-pengantar-magang',
                'description' => 'Surat pengantar resmi dari fakultas untuk pengajuan magang atau kerja praktik di perusahaan/instansi.',
                'requirements' => ['Transkrip Nilai Sementara', 'Proposal Magang'],
                'is_active' => true,
            ],
            [
                'name' => 'Surat Permohonan Penelitian Skripsi',
                'slug' => 'surat-penelitian-skripsi',
                'description' => 'Surat izin pengambilan data atau observasi untuk keperluan penyusunan tugas akhir/skripsi.',
                'requirements' => ['Lembar Persetujuan Judul', 'Kartu Rencana Studi (KRS)'],
                'is_active' => true,
            ],
        ];

        foreach ($letters as $letter) {
            LetterType::updateOrCreate(
                ['slug' => $letter['slug']],
                $letter
            );
        }
    }
}