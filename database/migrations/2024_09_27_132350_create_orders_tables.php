<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'completed'])->nullable();
            $table->integer('position')->unsigned()->nullable();
        });

        Schema::create('order_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'order');
        });

    }

    public function down()
    {
        Schema::dropIfExists('order_slugs');
        Schema::dropIfExists('orders');
    }
};
