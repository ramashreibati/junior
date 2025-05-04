<?php

use App\Models\MenuItems;
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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(MenuItems::class)->constrained()->onDelete('cascade');
            $table->string('name', length: 100);
      
            $table->string('description', length: 100);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
