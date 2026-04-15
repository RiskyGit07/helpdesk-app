<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // KOSONGKAN TABEL TERLEBIH DAHULU (Opsional)
        // ============================================
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TicketReply::truncate();
        Ticket::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ============================================
        // DATA TICKETS
        // ============================================
        
        $ticket1 = Ticket::create([
            'user_id' => 3,
            'ticket_id' => 'TCK-001',
            'subject' => 'Gagal login ke portal helpdesk',
            'message' => 'Saya tidak bisa login ke portal helpdesk. Setelah memasukkan username dan password, muncul error "Server Error 500". Mohon bantuannya segera karena saya perlu mengajukan komplain.',
            'priority' => 'high',
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ticket2 = Ticket::create([
            'user_id' => 4,
            'ticket_id' => 'TCK-002',
            'subject' => 'Akses LMS sangat lambat',
            'message' => 'Sejak 2 hari terakhir, akses ke LMS (Learning Management System) sangat lambat. Butuh waktu 5-10 menit untuk membuka satu halaman. Ini sangat mengganggu proses belajar mengajar.',
            'priority' => 'medium',
            'status' => 'in_progress',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ticket3 = Ticket::create([
            'user_id' => 5,
            'ticket_id' => 'TCK-003',
            'subject' => 'Reset password akun dosen',
            'message' => 'Saya lupa password akun dosen saya. Mohon bantuan untuk mereset password. Terima kasih.',
            'priority' => 'low',
            'status' => 'closed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ticket4 = Ticket::create([
            'user_id' => 6,
            'ticket_id' => 'TCK-004',
            'subject' => 'Fitur upload file error',
            'message' => 'Saya mencoba upload tugas tapi selalu gagal. Pesan error: "File too large" padahal ukuran file hanya 2MB. Mohon dicek konfigurasi upload maksimalnya.',
            'priority' => 'high',
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ticket5 = Ticket::create([
            'user_id' => 7,
            'ticket_id' => 'TCK-005',
            'subject' => 'Email notifikasi tidak masuk',
            'message' => 'Saya tidak menerima email notifikasi padahal sudah beberapa hari. Biasanya setiap ada pengumuman saya dapat email, sekarang tidak pernah.',
            'priority' => 'medium',
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ticket6 = Ticket::create([
            'user_id' => 3,
            'ticket_id' => 'TCK-006',
            'subject' => 'Tidak bisa akses e-learning',
            'message' => 'E-learning tidak bisa diakses sejak pagi ini. Error connection timeout.',
            'priority' => 'high',
            'status' => 'in_progress',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ticket7 = Ticket::create([
            'user_id' => 4,
            'ticket_id' => 'TCK-007',
            'subject' => 'Cetak transkrip nilai error',
            'message' => 'Saat mencetak transkrip nilai, muncul error dan halaman jadi blank. Sudah coba di browser lain tetap sama.',
            'priority' => 'medium',
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================================
        // DATA REPLIES (Balasan tiket)
        // ============================================

        // Reply untuk ticket 1 (TCK-001)
        TicketReply::create([
            'ticket_id' => $ticket1->id,
            'user_id' => 2,
            'message' => 'Terima kasih atas laporannya. Tim teknis kami sedang mengecek masalah ini. Kami akan segera memberikan update dalam 1x24 jam.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        TicketReply::create([
            'ticket_id' => $ticket1->id,
            'user_id' => 3,
            'message' => 'Terima kasih informasinya. Apakah ada update? Masih belum bisa login sampai sekarang.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Reply untuk ticket 2 (TCK-002)
        TicketReply::create([
            'ticket_id' => $ticket2->id,
            'user_id' => 2,
            'message' => 'Kami sudah menerima laporan Anda tentang LMS yang lambat. Sedang kami koordinasikan dengan tim jaringan untuk pengecekan server.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        TicketReply::create([
            'ticket_id' => $ticket2->id,
            'user_id' => 2,
            'message' => 'Update: Tim kami sedang melakukan maintenance pada server LMS. Diperkirakan akan normal kembali dalam 2 jam ke depan.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Reply untuk ticket 3 (TCK-003)
        TicketReply::create([
            'ticket_id' => $ticket3->id,
            'user_id' => 1,
            'message' => 'Password Anda sudah kami reset. Password baru: reset12345. Silakan login dan segera ganti password Anda di menu profil.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        TicketReply::create([
            'ticket_id' => $ticket3->id,
            'user_id' => 5,
            'message' => 'Terima kasih, sudah bisa login. Saya sudah ganti password. Mohon informasinya ditutup.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Reply untuk ticket 4 (TCK-004)
        TicketReply::create([
            'ticket_id' => $ticket4->id,
            'user_id' => 2,
            'message' => 'Kami telah mengecek konfigurasi upload. Batas maksimal upload adalah 10MB. Coba cek kembali ukuran file Anda. Jika masih error, silakan kirimkan screenshotnya.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================================
        // OUTPUT INFO KE TERMINAL
        // ============================================
        
        $this->command->info('========================================');
        $this->command->info('SEEDER BERHASIL DIJALANKAN!');
        $this->command->info('========================================');
        $this->command->info('Total Tickets: ' . Ticket::count());
        $this->command->info('Total Replies: ' . TicketReply::count());
        $this->command->info('========================================');
        
        // Detail per status
        $this->command->info('Detail Status Tickets:');
        $this->command->info('- Open: ' . Ticket::where('status', 'open')->count());
        $this->command->info('- In Progress: ' . Ticket::where('status', 'in_progress')->count());
        $this->command->info('- Closed: ' . Ticket::where('status', 'closed')->count());
        $this->command->info('========================================');
    }
}