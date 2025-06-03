<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{


    /**
     * Konstanta untuk nama peran.
     * Ini membantu menghindari kesalahan ketik dan membuat kode lebih mudah dibaca.
     */
    public const ROLE_ADMIN = 'admin';
    public const ROLE_EMPLOYEE = 'employee'; // Anda juga bisa menambahkan ini


    protected $fillable = [
        'name',
        'nip',
        'email',
        'password',
        'jadwal_kerja_mulai',
        'jadwal_kerja_selesai',
        'role', // Pastikan 'role' ada di sini
        'last_login_at', // Jika Anda sudah menambahkannya
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime', // Jika Anda sudah menambahkannya
    ];

    /**
     * Helper method untuk mengecek apakah pengguna adalah admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Helper method untuk mengecek apakah pengguna adalah employee (opsional).
     *
     * @return bool
     */
    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    // ... (relasi atau method lain jika ada) ...
}
