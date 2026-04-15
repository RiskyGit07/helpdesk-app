<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Kolom baru yang diperlukan
            $table->string('ticket_number')->unique()->nullable()->after('id');
            $table->string('user_identifier')->nullable()->after('user_id');
            $table->string('attachment')->nullable()->after('description');
            $table->timestamp('resolved_at')->nullable()->after('status');
            $table->string('assigned_to')->nullable()->after('resolved_at');
            $table->timestamp('assigned_at')->nullable()->after('assigned_to');
            $table->string('last_replied_by')->nullable()->after('assigned_at');
            
            // Ubah status enum jika perlu (sesuai kebutuhan)
            // DB::statement("ALTER TABLE tickets MODIFY status ENUM('open', 'in_progress', 'resolved') NOT NULL DEFAULT 'open'");
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'ticket_number',
                'user_identifier',
                'attachment',
                'resolved_at',
                'assigned_to',
                'assigned_at',
                'last_replied_by'
            ]);
        });
    }
};