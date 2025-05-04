<?php

use App\Models\Event;
use App\Models\User;
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
        Schema::create('event_booking', function (Blueprint $table) {
            $table->id('id');
            // $table->foreignId('user_id');
            // $table->foreignId('restaurant_id');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Event::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            
            $table->text('event_details');
            $table->dateTime('booking_date');
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_booking');
    }
};
