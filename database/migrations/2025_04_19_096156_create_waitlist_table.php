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
        Schema::create('waitlist', function (Blueprint $table) {
            $table->id('id');
            // $table->foreignId('user_id');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            // $table->foreignId('restaurant_id');
            $table->string('status', length: 100);
            $table->integer('table_number');
            $table->timestamp('date_time');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlist');
    }
};
