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
        'gender',
        'birth_date',
        'phone',
        'fakultas',
        'address',
        'prodi',
        'position',
        'profile_completed',
        'admin_profile_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Ganti email dengan username untuk login
    public function username()
    {
        return 'username';
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isMahasiswa()
    {
        return $this->user_type === 'mahasiswa';
    }

    public function isAsn()
    {
        return $this->user_type === 'pegawai_asn';
    }

    public function isNonAsn()
    {
        return $this->user_type === 'pegawai_non_asn';
    }
}