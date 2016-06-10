<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('event_file', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('file_id')->unsigned();
          $table->foreign('file_id')->references('id')->on('files');
          $table->integer('event_id')->unsigned();
          $table->foreign('event_id')->references('id')->on('events');
          $table->timestamps();

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_file');
    }
}
