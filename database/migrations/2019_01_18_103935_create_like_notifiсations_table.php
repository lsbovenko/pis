<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeNotifiсationsTable extends Migration
{
    /**
     * The table need not to send the huskies to the author several times. if not like,
     * the message will fly to the author and will have an entry in this table.
     * Like removed and the record is running out and next time the message is sent.
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_notifiсations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('idea_id')->unsigned();
            $table->foreign('idea_id')->references('id')->on('ideas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_notifiсations');
    }
}
