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
        Schema::create('pickup_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pickup_schedule_id')
                ->unique()
                ->constrained('pickup_schedules');

            $table->decimal('organic_weight_kg', 10, 2)->default(0);
            $table->decimal('inorganic_weight_kg', 10, 2)->default(0);

            $table->string('photo_path', 255)->nullable();
            $table->timestamp('collected_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_records');
    }
};
