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
        Schema::table('users', function (Blueprint $table) {
            $table->string('about')->nullable(); // About section
            $table->string('address')->nullable(); // Address field
            $table->string('phone')->nullable(); // Phone number
            $table->string('profile_picture')->nullable(); // Profile picture
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['about', 'address', 'phone', 'profile_picture']);
        });
    }
};