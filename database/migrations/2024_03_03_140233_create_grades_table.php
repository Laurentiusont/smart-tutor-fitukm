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
        Schema::create('grades', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->char('topic_guid', 50);
            $table->char('user_id', 10);
            $table->integer('grade')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('topic_guid')->references('guid')->on('topics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
