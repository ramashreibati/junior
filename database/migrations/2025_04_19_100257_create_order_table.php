<?php

use App\Models\Discount;
use App\Models\OrderDetails;
use App\Models\Restaurant;
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
        Schema::create('order', function (Blueprint $table) {
            $table->id('id');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(OrderDetails::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(Discount::class)->constrained()->onDelete('cascade');
            // $table->string('details');
            $table->string('price');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
