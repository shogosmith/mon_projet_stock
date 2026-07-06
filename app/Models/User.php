<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool {
        return $this->role === 'employee';
    }

    public function stockMovements() {
        return $this->hasMany(StockMovement::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}