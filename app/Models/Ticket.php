<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // ✅ WAJIB

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_id',
        'subject',
        'message',
        'priority',
        'status',
        'attachment',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->ticket_id = 'TCK-' . date('Ymd') . '-' . rand(1000,9999);
        });
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke reply
    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }
}