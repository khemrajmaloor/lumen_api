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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('user_login')->unique();
            $table->string('user_pass');
            $table->string('user_nicename')->unique();
            $table->string('user_email')->unique();
            $table->string('user_url')->nullable();
            $table->string('role')->default('admin');
            $table->timestamp('user_registered')->useCurrent();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
