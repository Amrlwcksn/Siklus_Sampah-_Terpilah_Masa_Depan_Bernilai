<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PickupSchedule extends Model
{
    protected $fillable = [
        'subscription_id',
        'address_id',
        'assigned_to',
        'scheduled_for',
        'status',
        'assigned_at',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_for' => 'datetime',
            'assigned_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // Jadwal terkait dengan satu langganan.
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    // Jadwal menggunakan satu alamat penjemputan.
    public function address(): BelongsTo
    {
        return $this->belongsTo(
            CustomerAddress::class,
            'address_id'
        );
    }

    // Jadwal dapat ditugaskan kepada satu petugas.
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Jadwal memiliki maksimal satu catatan hasil.
    public function pickupRecord(): HasOne
    {
        return $this->hasOne(PickupRecord::class);
    }
}
