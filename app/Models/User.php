<?php
// [Magfi Adi Radza Putra] - User Model

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Konstanta Role
    const ROLE_USER        = 'user';
    const ROLE_MANAGER     = 'manager';
    const ROLE_SUPER_ADMIN = 'super_admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ========== RELASI ==========
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Booking::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ========== HELPER ROLE ==========
    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function isManager()
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    // Cek apakah user memiliki salah satu role tertentu
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Cek apakah user termasuk dalam array role
    public function hasAnyRole(array $roles)
    {
        return in_array($this->role, $roles);
    }
}