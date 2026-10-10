<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude',
        'is_primary',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_primary' => 'boolean',
        ];
    }

    // Alamat ini dimiliki oleh satu user.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Alamat ini dapat digunakan pada banyak jadwal penjemputan.
    public function pickupSchedules(): HasMany
    {
        return $this->hasMany(PickupSchedule::class, 'address_id');
    }
}
