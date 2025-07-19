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
        Schema::create('hotel_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('password');
            $table->string('email');
            $table->text('description')->nullable();
            $table->decimal('default_price', 8, 2);
            $table->text('room_types')->nullable();
            $table->string('phone_number');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_requests');
    }
};
