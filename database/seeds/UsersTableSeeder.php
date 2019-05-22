<?php

use Illuminate\Database\Seeder;
use App\Helpers\Seed;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'name' => 'Admin',
                'email' => 'admin@data4change.com',
                'email_verified_at' => Seed::generateCurrentDate(),
                'password' => Seed::getDefaultPassword(),
                'remember_token' => Seed::generateRememberToken()
            ],
        ];

        Seed::insertData(User::class, $rows);
    }
}
