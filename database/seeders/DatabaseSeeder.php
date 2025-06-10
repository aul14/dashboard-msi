<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::insert([
            [
                'username' => 'admin',
                'fullname' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'level_user' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'user',
                'fullname' => 'User Operator',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user'),
                'level_user' => 'operator',
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
