<?php

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
        Schema::create('virtual_tour', function (Blueprint $table) {
            $table->id('id');
            // $table->foreignId('restaurant_id');
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            $table->string('video_link', length: 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_tour');
    }
};
