<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->text('description')->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->boolean('completed')->default(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->nullable(false);
            $table->enum('status', ['todo', 'doing', 'done'])->default('todo');
            $table->date('due_date')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
