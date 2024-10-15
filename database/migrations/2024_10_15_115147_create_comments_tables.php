<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            $table->foreignId('user_id')->constrained('users');
            $table->text('body');
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type');
            $table->integer('position')->unsigned()->nullable();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();

            // this will create the required columns to support nesting for this module
            $table->nestedSet();
        });

        Schema::create('comment_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'comment');
        });

        Schema::create('comment_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'comment');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comment_revisions');
        Schema::dropIfExists('comment_slugs');
        Schema::dropIfExists('comments');
    }
};
