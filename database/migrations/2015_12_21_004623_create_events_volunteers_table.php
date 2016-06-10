<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('event_volunteers', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('volunteer_id')->unsigned();
          $table->foreign('volunteer_id')->references('id')->on('volunteers');
          $table->integer('event_id')->unsigned();
          $table->foreign('event_id')->references('id')->on('events');
          $table->string('Relationship');
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
        Schema::drop('event_volunteers');
    }
}
