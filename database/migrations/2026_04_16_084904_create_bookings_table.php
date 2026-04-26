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
        Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        
        // link users table (Who rented)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // link rooms table (Which room)
        $table->foreignId('room_id')->constrained()->onDelete('cascade');
        
        $table->date('start_date'); // Rental start
        $table->date('end_date');   // Rental end
        $table->decimal('total_price', 8, 2); // total price for the booking
        $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending'); // status of the booking
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
