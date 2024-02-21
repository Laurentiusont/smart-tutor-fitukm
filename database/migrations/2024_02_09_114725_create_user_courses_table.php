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
        Schema::create('user_courses', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->char('course_code', 10);
            $table->char('user_id', 10);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('course_code')->references('code')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_mata_kuliah');
    }
};
