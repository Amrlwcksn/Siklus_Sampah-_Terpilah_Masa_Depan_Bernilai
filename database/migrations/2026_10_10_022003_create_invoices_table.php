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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subscription_id')
                ->constrained('subscriptions');

            $table->string('invoice_number', 50)->unique();
            $table->unsignedBigInteger('amount')->default(25000);

            $table->timestamp('period_start');
            $table->timestamp('period_end');
            $table->timestamp('due_at');
            $table->timestamp('grace_until')->nullable();

            $table->enum('status', [
                'unpaid',
                'paid',
                'expired',
                'cancelled',
            ])->default('unpaid');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->unique(['subscription_id', 'period_start']);
            $table->index(['status', 'due_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
