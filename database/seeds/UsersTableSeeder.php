<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = \teambernieny\User::firstOrCreate(['email' => 'app@teambernieny.org']);
      $user->name = 'Admin';
      $user->email = 'app@teambernieny.org';
      $user->password = \Hash::make('B3rn90()');
      $user->role = 'admin';
      $user->save();

      $user = \teambernieny\User::firstOrCreate(['email' => 'annalisa.wilde@gmail.com']);
      $user->name = 'Annalisa';
      $user->email = 'annalisa.wilde@gmail.com';
      $user->password = \Hash::make('B3rn90()');
      $user->role = 'admin';
      $user->save();
    }
}
