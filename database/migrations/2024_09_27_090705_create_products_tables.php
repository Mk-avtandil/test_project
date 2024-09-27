<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->string('type')->index();
            $table->string('color');
            $table->string('size');
            $table->decimal('price', 8, 2); // цена с 2 знаками после запятой
            $table->boolean('is_in_stock')->default(true);
            $table->text('description')->nullable();
            $table->integer('position')->unsigned()->nullable();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('product_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'product');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_revisions');
        Schema::dropIfExists('products');
    }
};
