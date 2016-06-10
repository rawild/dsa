<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('commitments', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('event_volunteers_id')->unsigned();
          $table->foreign('event_volunteers_id')->references('id')->on('event_volunteers');
          $table->string('Type');
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
        Schema::drop('commitments');
    }
}
