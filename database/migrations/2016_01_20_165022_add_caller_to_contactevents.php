<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCallerToContactevents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('contactevents', function ($table) {
        $table->string('Caller')->nullable();
        $table->string('PickedUp')->nullable();
        $table->integer('event_id')->unsigned()->nullable();
        $table->foreign('event_id')->references('id')->on('events');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('contactevents', function (Blueprint $table) {
        $table->dropColumn('Caller');
        $table->dropColumn('PickedUp');
        $table->dropForeign('contactevents_event_id_foreign');
        $table->dropColumn('event_id');

      });
    }
}
