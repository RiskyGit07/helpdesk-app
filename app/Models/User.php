<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'user_type',
        'role',
        'nim',
        'nik',
        'nip',
        'gender',
        'birth_date',
        'phone',
        'faculty',
        'address',
        'study_program',
        'position',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    // Helper untuk menampilkan gender dalam bentuk teks
    public function getGenderLabelAttribute()
    {
        return $this->gender == 'male' ? 'Laki-laki' : 'Perempuan';
    }

    // Untuk login menggunakan username (TANPA email)
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function isAdmin()
    {
        return $this->email === 'admin@helpdesk.com';
    }
=======
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];
>>>>>>> 0427184526c5dd354cf4f90f4767968228efb2b1
}