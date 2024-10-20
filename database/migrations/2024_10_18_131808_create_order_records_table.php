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
        Schema::create('order_records', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('user_ip');
            $table->string('device_name');
            $table->string('product_name');
            $table->integer('quantity');
            $table->string('status');
            $table->integer('price');
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_records');
    }
};
