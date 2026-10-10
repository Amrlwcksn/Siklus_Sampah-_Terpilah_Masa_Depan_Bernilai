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
        Schema::create('pickup_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subscription_id')
                ->constrained('subscriptions');

            $table->foreignId('address_id')
                ->constrained('customer_addresses');

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users');

            $table->timestamp('scheduled_for');

            $table->enum('status', [
                'scheduled',
                'assigned',
                'in_progress',
                'completed',
                'skipped',
                'failed',
            ])->default('scheduled');

            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['scheduled_for', 'status']);
            $table->index(['assigned_to', 'scheduled_for']);

            $table->unique(['subscription_id', 'scheduled_for']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_schedules');
    }
};
