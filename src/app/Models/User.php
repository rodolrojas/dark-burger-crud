<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $user): void {
            if (! $user->getKey() && Schema::hasTable('users') && Schema::getColumnType('users', 'id') === 'uuid') {
                $user->setAttribute($user->getKeyName(), (string) Str::uuid());
            }
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function canUseRole(string ...$roles): bool
    {
        return $this->active && in_array($this->role, $roles, true);
    }
}
