<?php

use App\Models\Restaurant;
use App\Models\Restaurants;
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
        Schema::create('discount', function (Blueprint $table) {
            $table->id('id');
            // $table->foreignId('user_id');
            // $table->foreignId('restaurant_id');
            $table->string('discount_code', length: 100);
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            
            $table->float('discount_amount');
            $table->date('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount');
    }
};
