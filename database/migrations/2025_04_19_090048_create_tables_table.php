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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('type', length: 100);
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            $table->integer('count')->default(0);
            $table->boolean('is_available')->default(true); 
            // Grouped tables will share the same ID
            // $table->string('location', length: 100);
            $table->integer('number_of_persons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('tables');
    }
};
