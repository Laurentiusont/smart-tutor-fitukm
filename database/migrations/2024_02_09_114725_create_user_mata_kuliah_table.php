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
        Schema::create('user_mata_kuliah', function (Blueprint $table) {
            $table->increments('id');
            $table->char('mata_kuliah_kode', 10);
            $table->char('users_id', 10);
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('mata_kuliah_kode')->references('kode')->on('mata_kuliah')->onDelete('cascade');
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
