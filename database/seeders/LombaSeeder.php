<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lomba;
use App\Models\User; // Pastikan untuk mengimpor model User

class LombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari user pertama dengan role 'admin' untuk dijadikan penulis lomba
        $admin = User::where('role', 'admin')->first();

        // 2. Jika admin tidak ditemukan, hentikan seeder dengan pesan error
        if (!$admin) {
            $this->command->error('Tidak ditemukan user dengan role admin. Harap jalankan UserSeeder terlebih dahulu.');
            return;
        }

        // 3. Buat beberapa data lomba
        Lomba::create([
            'user_id'   => $admin->id, // Gunakan ID admin yang ditemukan
            'title'     => 'INVORVATION 2025',
            'content'   => 'Registrasi Gelombang 1 untuk INFORVATION 2025 telah resmi DIBUKA! Kompetisi IT tahunan terbesar dengan berbagai cabang lomba seperti Competitive Programming, UI/UX Design, dan Web Development. Segera daftarkan tim Anda dan menangkan total hadiah puluhan juta rupiah.',
            'image'     => 'storage/lomba1.jpeg',
            'created_at'=> now(),
            'updated_at'=> now(),
            'view_count'=> 0,
        ]);
    }
}