<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {

      // Create root user
      DB::table('users')->insert([
            'name' => 'root',
            'email' => 'root@gmail.com',
            'password' => '$2y$10$lISh2q71LWgJ0rJrPPXTnu.YAhEvcigysqIouUHGEaZU08S.mNyq6', // secret: 123456,
            'is_admin' => 1
      ]);

      // Then create 10 random groups
      for($i=0; $i<=10; $i++){
        DB::table('groups')->insert([
              'name' => $faker->stateAbbr
        ]);
      }

      // Then create 50 random users
      for($i=0; $i<=50; $i++){
        DB::table('users')->insert([
              'name' => $faker->username,
              'email' => $faker->email,
              'password' => '$2y$10$lISh2q71LWgJ0rJrPPXTnu.YAhEvcigysqIouUHGEaZU08S.mNyq6', // secret: 123456,
              'is_admin' => 0
        ]);
      }

      // Then create 50 random users
      for($i=0; $i<=50; $i++){
        DB::table('user_groups')->insert([
              'user_id' => rand(1,50),
              'group_id' => rand(1,10)
        ]);
      }


    }
}
