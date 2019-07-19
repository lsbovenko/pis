<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasExecutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas_executors', function (Blueprint $table) {
            $table->integer('idea_id')->unsigned();
            $table->integer('executor_id')->unsigned();
            $table->primary(['idea_id', 'executor_id']);

            $table->foreign('idea_id', 'FK_IDEAS_EXECUTORS_IDEA_ID')
                ->references('id')->on('ideas')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('executor_id', 'FK_IDEAS_EXECUTORS_EXECUTOR_ID')
                ->references('id')->on('users')
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
        Schema::dropIfExists('ideas_executors');
    }
}
