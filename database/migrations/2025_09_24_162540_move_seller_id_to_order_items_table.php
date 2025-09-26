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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('seller_id')->after('product_id')->constrained('users')->onDelete('cascade');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('seller_id')->nullable()->constrained('users')->onDelete('cascade');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn('seller_id');
        });
    }
};
