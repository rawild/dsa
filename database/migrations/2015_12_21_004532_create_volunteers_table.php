<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('volunteers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('FirstName')->nullable();
          $table->string('LastName')->nullable();
          $table->string('Email')->nullable();
          $table->string('Phone')->nullable();
          $table->integer('neighborhood_id')->unsigned();
          $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');
          $table->integer('Zip')->nullable();
          $table->text('Street')->nullable();
          $table->string('City')->nullable();
          $table->string('State')->nullable();
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');
          $table->boolean('BadPhone')->nullable();
          $table->boolean('BadEmail')->nullable();
          $table->boolean('DoNotContact')->nullable();
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
        Schema::drop('volunteers');
    }
}
