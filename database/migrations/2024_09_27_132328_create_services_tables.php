<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            $table->string('type')->index();
            $table->decimal('price', 8, 2);
            $table->date('deadline');
            $table->string('example_link')->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->nestedSet();
        });

        Schema::create('service_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'service');
        });

        Schema::create('service_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'service');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_revisions');
        Schema::dropIfExists('service_slugs');
        Schema::dropIfExists('services');
    }
};
