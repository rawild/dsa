<?php

use Illuminate\Database\Seeder;

class NeighborhoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('neighborhoods')->insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'Name' => "Unknown",
        'Borough' => "Unknown"
      ]);
    }
}
