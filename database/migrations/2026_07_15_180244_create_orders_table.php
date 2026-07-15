<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->string('status')->default('pending');
            $table->string('payment_method');
            $table->string('delivery_method');
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('delivery_fee');
            $table->unsignedBigInteger('total');
            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};