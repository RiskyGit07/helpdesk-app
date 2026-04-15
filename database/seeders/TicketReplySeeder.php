<?php

namespace Database\Seeders;

use App\Models\TicketReply;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketReplySeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TicketReply::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data replies
        $replies = [
            ['ticket_id' => 1, 'user_id' => 2, 'message' => 'Terima kasih atas laporannya. Tim teknis kami sedang mengecek masalah ini. Kami akan segera memberikan update dalam 1x24 jam.'],
            ['ticket_id' => 1, 'user_id' => 3, 'message' => 'Terima kasih informasinya. Apakah ada update? Masih belum bisa login sampai sekarang.'],
            ['ticket_id' => 2, 'user_id' => 2, 'message' => 'Kami sudah menerima laporan Anda tentang LMS yang lambat. Sedang kami koordinasikan dengan tim jaringan untuk pengecekan server.'],
            ['ticket_id' => 2, 'user_id' => 2, 'message' => 'Update: Tim kami sedang melakukan maintenance pada server LMS. Diperkirakan akan normal kembali dalam 2 jam ke depan.'],
            ['ticket_id' => 3, 'user_id' => 1, 'message' => 'Password Anda sudah kami reset. Password baru: reset12345. Silakan login dan segera ganti password Anda di menu profil.'],
            ['ticket_id' => 3, 'user_id' => 5, 'message' => 'Terima kasih, sudah bisa login. Saya sudah ganti password. Mohon informasinya ditutup.'],
            ['ticket_id' => 4, 'user_id' => 2, 'message' => 'Kami telah mengecek konfigurasi upload. Batas maksimal upload adalah 10MB. Coba cek kembali ukuran file Anda. Jika masih error, silakan kirimkan screenshotnya.'],
        ];

        foreach ($replies as $reply) {
            TicketReply::create([
                'ticket_id' => $reply['ticket_id'],
                'user_id' => $reply['user_id'],
                'message' => $reply['message'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}