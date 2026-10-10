<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PickupRecord extends Model
{
    protected $fillable = [
        'pickup_schedule_id',
        'organic_weight_kg',
        'inorganic_weight_kg',
        'photo_path',
        'collected_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'organic_weight_kg' => 'decimal:2',
            'inorganic_weight_kg' => 'decimal:2',
            'collected_at' => 'datetime',
        ];
    }

    // Catatan merupakan hasil dari satu jadwal penjemputan.
    public function pickupSchedule(): BelongsTo
    {
        return $this->belongsTo(PickupSchedule::class);
    }
}
