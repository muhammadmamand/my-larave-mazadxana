<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'bio',
        'avatar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function winningBids(): HasMany
    {
        return $this->hasMany(Bid::class)->where('is_winning', true);
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim($this->name));

        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1).substr(end($parts), 0, 1));
        }

        return strtoupper(substr($this->name, 0, 2));
    }

    public function avatarUrl(): ?string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return Storage::disk('public')->url($this->avatar);
        }

        return null;
    }
}
