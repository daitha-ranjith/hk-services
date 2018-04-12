<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conference_id')->unsigned();
            $table->string('sid')->index();
            $table->string('participant');
            $table->integer('duration');
            $table->timestamps();

            $table->foreign('conference_id')
                  ->references('id')
                  ->on('conferences')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->unique(['conference_id', 'participant']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
