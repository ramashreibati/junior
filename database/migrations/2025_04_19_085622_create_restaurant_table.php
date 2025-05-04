<?php

use App\Models\address;
use App\Models\Event;
use App\Models\Feature;
use App\Models\Reservation;
use App\Models\Tables;
use App\Models\User;
use App\Models\VirtualTour;
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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', length: 100);
            $table->string('location', length: 100);
            $table->string('type', length: 100);
            $table->string('cuisine_type', length: 100);
            // $table->string('google_map_link', length: 100);
            // $table->integer('table_number');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(address::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(Tables::class)->constrained()->onDelete('cascade');
            // $table->foreignId('feature_id');
            // $table->foreignId('street_id');
            $table->string('event_calender');
            $table->float('ratings');
     
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
