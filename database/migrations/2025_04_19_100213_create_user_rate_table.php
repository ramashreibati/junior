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
        Schema::create('user_rate', function (Blueprint $table) {
            $table->id('id');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Restaurants::class)->constrained()->onDelete('cascade');
            $table->enum('rate',['1','2','3','4','5']);
            $table->text('review')->nullable();
            // $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rate');
    }
};
