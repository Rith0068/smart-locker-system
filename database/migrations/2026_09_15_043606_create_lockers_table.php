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
        Schema::create('lockers', function (Blueprint $table) {
            $table->id();
            $table->string('locker_title');
            $table->string('size')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('locations_id')->constrained()->cascadeOnDelete();
            $table->string('start')->nullable();
            $table->string('releave')->nullable();
            $table->string('password')->unique()->nullable();
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lockers');
    }
};
