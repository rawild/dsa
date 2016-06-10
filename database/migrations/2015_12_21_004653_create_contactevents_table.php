<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContacteventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('contactevents', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamp('Date');
          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users');
          $table->integer('volunteer_id')->unsigned();
          $table->foreign('volunteer_id')->references('id')->on('volunteers');
          $table->string('Purpose')->nullable();
          $table->boolean('RSVP')->nullable();
          $table->boolean('Call')->nullable();
          $table->boolean('VoiceMail')->nullable();
          $table->boolean('Text')->nullable();
          $table->boolean('Email')->nullable();
          $table->text('Comment')->nullable();
          $table->boolean('Completed')->nullable();
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
          Schema::drop('contactevents');
    }
}
