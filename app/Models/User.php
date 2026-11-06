<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, MustVerifyEmailTrait, Notifiable;

    /**
     * Nama tabel database legacy.
     */
    protected $table = 'users';

    /**
     * Primary key tabel users legacy.
     */
    protected $primaryKey = 'id_user';

    /**
     * Primary key bertipe auto increment.
     */
    public $incrementing = true;

    /**
     * Tipe primary key.
     */
    protected $keyType = 'int';

    /**
     * Kolom yang dapat diisi.
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role',
        'is_verified',
    ];

    /**
     * Kolom yang disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Kompatibilitas dengan pemakaian $user->name.
     */
    public function getNameAttribute(): string
    {
        return (string) $this->full_name;
    }

    /**
     * Status verifikasi memakai kolom legacy is_verified.
     */
    public function hasVerifiedEmail(): bool
    {
        return (bool) $this->is_verified;
    }

    /**
     * Tandai email terverifikasi pada kolom legacy.
     */
    public function markEmailAsVerified(): bool
    {
        if ($this->hasVerifiedEmail()) {
            return false;
        }

        return $this->forceFill(['is_verified' => true])->save();
    }

    /**
     * Kompatibilitas tampilan Breeze yang memakai email_verified_at.
     */
    public function getEmailVerifiedAtAttribute(): ?Carbon
    {
        return $this->is_verified ? $this->updated_at : null;
    }

    /**
     * Relasi profil UMKM milik user.
     */
    public function smeProfiles()
    {
        return $this->hasMany(SmeProfile::class, 'id_user', 'id_user');
    }
}
