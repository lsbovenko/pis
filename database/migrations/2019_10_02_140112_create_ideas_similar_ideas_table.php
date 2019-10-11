<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasSimilarIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas_similar_ideas', function (Blueprint $table) {
            $table->integer('idea_id')->unsigned();
            $table->integer('similar_idea_id')->unsigned();
            $table->primary(['idea_id', 'similar_idea_id']);

            $table->foreign('idea_id', 'FK_IDEAS_IDEA_ID')
                ->references('id')->on('ideas')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('similar_idea_id', 'FK_IDEAS_SIMILAR_IDEA_ID')
                ->references('id')->on('ideas')
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
        Schema::dropIfExists('ideas_similar_ideas');
    }
}
