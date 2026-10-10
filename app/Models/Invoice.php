<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'subscription_id',
        'invoice_number',
        'amount',
        'period_start',
        'period_end',
        'due_at',
        'grace_until',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'period_start' => 'datetime',
            'period_end' => 'datetime',
            'due_at' => 'datetime',
            'grace_until' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    // Tagihan dimiliki oleh satu langganan.
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    // Satu tagihan dapat memiliki beberapa percobaan pembayaran.
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
