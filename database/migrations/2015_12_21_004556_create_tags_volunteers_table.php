<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tag_volunteer', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('volunteer_id')->unsigned();
          $table->foreign('volunteer_id')->references('id')->on('volunteers');
          $table->integer('tag_id')->unsigned();
          $table->foreign('tag_id')->references('id')->on('tags');
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
        Schema::drop('tag_volunteer');
    }
}
