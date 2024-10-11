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
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('orderable_id');
            $table->string('orderable_type');
            $table->integer('quantity')->default(1);
            $table->enum('status', ['pending', 'completed']);
            $table->integer('position')->unsigned()->nullable();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('order_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'order');
        });

        Schema::create('order_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_revisions');
        Schema::dropIfExists('order_slugs');
        Schema::dropIfExists('orders');
    }
};
