<?php

namespace App\Shared\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id_user
 * @property string $full_name
 * @property string $email
 * @property string $role
 * @property bool $is_verified
 * @property-read string $name
 * @property-read Carbon|null $email_verified_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SmeProfile> $smeProfiles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, BusinessProfile> $businessProfiles
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, MustVerifyEmailTrait, Notifiable;

    protected static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }

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
     *
     * Saat EMAIL_VERIFICATION_ENABLED=false, verifikasi email tidak menjadi
     * gerbang: fungsi ini selalu true sehingga semua pengecekan verifikasi
     * (middleware "verified", alur login/registrasi) otomatis lolos.
     * Halaman verifikasi tetap dapat dikunjungi, tetapi tidak dipaksakan.
     */
    public function hasVerifiedEmail(): bool
    {
        if (! config('app.email_verification_enabled')) {
            return true;
        }

        return (bool) $this->is_verified;
    }

    /**
     * Tandai email terverifikasi pada kolom legacy.
     */
    public function markEmailAsVerified(): bool
    {
        // Cek kolom langsung (bukan hasVerifiedEmail()) supaya is_verified
        // tetap terisi walaupun verifikasi sedang tidak dipaksakan.
        if ($this->is_verified) {
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
    public function smeProfiles(): HasMany
    {
        return $this->hasMany(SmeProfile::class, 'id_user', 'id_user');
    }

    /**
     * Relasi profil usaha hasil onboarding registrasi.
     */
    public function businessProfiles(): HasMany
    {
        return $this->hasMany(BusinessProfile::class, 'id_user', 'id_user');
    }
}