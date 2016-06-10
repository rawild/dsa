<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCdCountyToVolunteers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('volunteers', function ($table) {
        $table->integer('CDistrict')->nullable();
        $table->string('County')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('volunteers', function (Blueprint $table) {

        $table->dropColumn('CDistrict');
        $table->dropColumn('County');
      });
    }
}
