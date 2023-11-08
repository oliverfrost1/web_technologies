<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('role')->default('user');
        });

        // create an admin user
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@todo.dk',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'created_at' => now(),
        ]);

    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
