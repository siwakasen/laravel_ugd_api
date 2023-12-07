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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_restaurant')->nullable();
            $table->unsignedBigInteger('id_voucher')->nullable();
            // $table->unsignedBigInteger('id_subscriptions')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_restaurant')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('id_voucher')->references('id')->on('vouchers')->onDelete('cascade');
            // $table->foreign('id_subscriptions')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->string('address_on_trans')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('delivery_fee')->nullable();
            $table->float('order_fee')->nullable();
            $table->float('total')->nullable();
            $table->string('status')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->timestamp('datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
