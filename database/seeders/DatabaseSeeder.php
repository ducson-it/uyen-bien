<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create(
            [
                'name' => 'duc son',
                'email' => 'ducson.nuce@gmail.com',
                'password' => Hash::make('123'),
                'is_admin' => 1
            ]
            );
    }
}
