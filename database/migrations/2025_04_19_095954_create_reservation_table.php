<?php

use App\Models\Tables;
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
        Schema::create('reservation', function (Blueprint $table) {
            $table->id('id');
           $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->string('name', length: 100);
            $table->integer('number_of_persons');
            $table->text('notes');
            $table->dateTime('reserve_from'); 
            $table->dateTime( 'reserve_until'); 

            $table->string('status')->default('upcoming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
