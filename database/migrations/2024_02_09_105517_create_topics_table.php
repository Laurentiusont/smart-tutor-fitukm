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
        Schema::create('topics', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->char('name', 100);
            $table->string('description')->nullable();
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->char('course_code', 10);
            $table->foreign('course_code')->references('code')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
