<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'monthly_fee',
        'status',
        'started_at',
        'current_period_start',
        'current_period_end',
        'grace_until',
        'suspended_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'monthly_fee' => 'integer',
            'started_at' => 'datetime',
            'current_period_start' => 'datetime',
            'current_period_end' => 'datetime',
            'grace_until' => 'datetime',
            'suspended_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    // Langganan dimiliki oleh satu user.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Langganan memiliki banyak tagihan.
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    // Langganan memiliki banyak jadwal penjemputan.
    public function pickupSchedules(): HasMany
    {
        return $this->hasMany(PickupSchedule::class);
    }
}
