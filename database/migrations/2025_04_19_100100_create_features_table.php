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
        Schema::create('features', function (Blueprint $table) {
            $table->id('id');
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            $table->string('type', length: 100);
            $table->string('description', length: 100);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
