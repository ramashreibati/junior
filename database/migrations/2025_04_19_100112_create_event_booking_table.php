<?php

use App\Models\Restaurants;
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
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('event_name', 100);
            $table->integer('number_of_persons');
            $table->dateTime('book_from');
            $table->dateTime('book_until');
            $table->text('event_details')->nullable();
            $table->string('status')->default('upcoming'); // ✅ No more `table_id`
            $table->timestamps();
        });
        
        // Create Pivot Table for Many-to-Many Relationship
        Schema::create('event_booking_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_booking_id')->constrained('event_bookings')->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_booking_tables'); // ✅ Remove pivot table first
        Schema::dropIfExists('event_bookings');
    }
};
