<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasUuids;

    protected $fillable = [
        'code',
        'name',
        'type',
        'active',
        'configuration',
    ];

    protected $casts = [
        'active' => 'boolean',
        'configuration' => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
