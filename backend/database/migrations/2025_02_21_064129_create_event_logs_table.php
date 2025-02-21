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
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 64);
            $table->timestamp('date');
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->jsonb('data')->default("{}");

            $table->index('booking_id');
            $table->index('user_id');
        });

        \DB::statement('CREATE INDEX brin_events_date ON event_logs USING BRIN (date)');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement('DROP INDEX IF EXISTS brin_events_date');

        Schema::dropIfExists('event_logs');
    }
};
