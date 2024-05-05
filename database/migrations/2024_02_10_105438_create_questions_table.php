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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->string('question_ai');
            $table->text('answer_ai');
            $table->string('question_fix');
            $table->text('answer_fix');
            $table->float('weight');
            $table->char('category', 30);
            $table->char('topic_guid', 36);
            $table->string('page')->nullable();
            $table->float('cossine_similarity')->nullable();
            $table->foreign('topic_guid')->references('guid')->on('topics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
