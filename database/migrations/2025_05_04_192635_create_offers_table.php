<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Restaurants;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignIdFor( Restaurants::class)->constrained()->onDelete('cascade'); // Link to restaurant

            $table->string( 'title',255); // Offer title
            $table->text( 'description'); // Offer description
            $table->float('discount_percentage'); // Discount percentage
            $table->date('valid_from'); // Offer start date
            $table->date( 'valid_until'); // Offer end date
            $table->boolean( 'is_featured')->default(false); // Featured for homepage

            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
