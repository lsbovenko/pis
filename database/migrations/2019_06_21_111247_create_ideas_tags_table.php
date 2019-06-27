<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas_tags', function (Blueprint $table) {
            $table->integer('idea_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->primary(['idea_id', 'tag_id']);

            $table->index('idea_id', 'IDX_IDEAS_TAGS_IDEA_ID');
            $table->index('tag_id', 'IDX_IDEAS_TAGS_TAG_ID');

            $table->foreign('idea_id', 'FK_IDEAS_TAGS_IDEA_ID')
                ->references('id')->on('ideas')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id', 'FK_IDEAS_TAGS_TAG_ID')
                ->references('id')->on('tags')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas_tags');
    }
}
