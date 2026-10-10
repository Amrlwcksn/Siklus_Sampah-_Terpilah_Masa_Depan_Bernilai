<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained('invoices');

            $table->string('order_id', 100)->unique();
            $table->string('transaction_id', 100)->nullable()->unique();

            $table->string('payment_type', 50)->nullable();

            $table->enum('transaction_status', [
                'pending',
                'settlement',
                'capture',
                'expire',
                'cancel',
                'deny',
                'failure',
            ])->default('pending');

            $table->string('fraud_status', 30)->nullable();
            $table->unsignedBigInteger('gross_amount');

            $table->timestamp('transaction_time')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->json('notification_payload')->nullable();

            $table->timestamps();

            $table->index(['invoice_id', 'transaction_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
