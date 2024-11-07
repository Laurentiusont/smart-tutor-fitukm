<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id'); // Foreign key reference
            $table->string('zoom_user_id')->nullable(); // Remove 'after' here
            $table->text('zoom_access_token')->nullable(); // Remove 'after' here
            $table->text('zoom_refresh_token')->nullable(); // Ensure this column exists for token refresh
            $table->timestamp('zoom_token_expires_at')->nullable(); // Remove 'after' here
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists('users');
    }
};
