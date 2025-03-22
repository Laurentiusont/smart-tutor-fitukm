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
        Schema::create('meetings', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->char('topic_guid', 50);
            $table->string('description');
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->string('link')->nullable();
            $table->string('meeting_password')->nullable();
            $table->string('meeting_id')->nullable();
            $table->boolean('is_manual_link')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
