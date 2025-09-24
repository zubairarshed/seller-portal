<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade'); // seller who owns the order
            $table->string('buyer_name');
            $table->string('buyer_email')->nullable();
            $table->string('buyer_phone');
            $table->text('shipping_address');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
