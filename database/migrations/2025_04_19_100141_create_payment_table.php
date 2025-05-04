<?php

use App\Models\Reservation;
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
        Schema::create('payment', function (Blueprint $table) {
            $table->id('id');
            // $table->foreignId('user_id');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Reservation::class)->constrained()->onDelete('cascade');
            // $table->foreignId('reservation_id');
            $table->string('payment_method', length: 100);
            $table->float('amountPayed');
            // $table->timestamp('payment_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
