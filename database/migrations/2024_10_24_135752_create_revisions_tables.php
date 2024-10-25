<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->string('username');
            $table->string('email');
            $table->string('user_ip');
            $table->string('device_name');
            $table->string('product_name');
            $table->integer('quantity');
            $table->string('status');
            $table->integer('price');
            $table->integer('total_price');
        });
    }

    public function down()
    {
        Schema::dropIfExists('revisions');
    }
};
