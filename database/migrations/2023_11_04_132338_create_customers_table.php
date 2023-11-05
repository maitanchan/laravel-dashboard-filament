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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('slug')->unique();
            $table->date('date');
            $table->string('phone');
            $table->enum('gender', ['nam', 'nữ']);
            $table->string('social')->nullable();
            $table->string('email');
            $table->string('rank');
            $table->longText('desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
