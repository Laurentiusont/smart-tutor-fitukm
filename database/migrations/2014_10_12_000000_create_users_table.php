<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 50)->primary();
            $table->string('username');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('zoom_user_id')->nullable(); // Remove 'after' here
            $table->text('zoom_access_token')->nullable(); // Remove 'after' here
            $table->text('zoom_refresh_token')->nullable(); // Ensure this column exists for token refresh
            $table->timestamp('zoom_token_expires_at')->nullable(); // Remove 'after' here
            $table->char('role_guid', 36);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_guid')->references('guid')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
