<?php

namespace App\Models;

use App\Models\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'user_identifier',
        'title',
        'description',
        'attachment',
        'status',
        'resolved_at',
        'assigned_to',
        'assigned_at',
        'last_replied_by',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'assigned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class)->latest();
    }
}