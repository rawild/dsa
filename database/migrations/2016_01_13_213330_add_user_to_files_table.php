<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('files', function ($table) {
        $table->integer('user_id')->unsigned()->nullable();
        $table->foreign('user_id')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('files', function (Blueprint $table) {

        # ref: http://laravel.com/docs/5.1/migrations#dropping-indexes
        # combine tablename + fk field name + the word "foreign"
        $table->dropForeign('files_user_id_foreign');

        $table->dropColumn('user_id');
      });
    }
}
