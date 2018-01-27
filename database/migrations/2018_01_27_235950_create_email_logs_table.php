<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('token_id')->unsigned();
            $table->json('email');
            $table->timestamps();

            $table->foreign('token_id')->references('id')->on('tokens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_logs');
    }
}
