<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(NeighborhoodsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(VolunteersTableSeeder::class);

        Model::reguard();
    }
}
