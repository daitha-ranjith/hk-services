<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sid')->unique();
            $table->integer('token_id')->unsigned();
            $table->string('sent_to')->index();
            $table->string('message');
            $table->string('status')->index();
            $table->integer('characters');
            $table->datetime('sent_at')->nullable();
            $table->datetime('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('token_id')
                  ->references('id')
                  ->onUpdate('cascade')
                  ->onDelete('cascade')
                  ->on('tokens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
}
