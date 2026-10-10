<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'order_id',
        'transaction_id',
        'payment_type',
        'transaction_status',
        'fraud_status',
        'gross_amount',
        'transaction_time',
        'paid_at',
        'notification_payload',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount' => 'integer',
            'transaction_time' => 'datetime',
            'paid_at' => 'datetime',
            'notification_payload' => 'array',
        ];
    }

    // Pembayaran terkait dengan satu tagihan.
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
