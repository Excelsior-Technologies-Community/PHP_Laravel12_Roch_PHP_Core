<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Ramesh Patel', 'email' => 'ramesh@gmail.com', 'status' => 'active'],
            ['name' => 'Priya Sharma', 'email' => 'priya@gmail.com', 'status' => 'active'],
            ['name' => 'Suresh Kumar', 'email' => 'suresh@gmail.com', 'status' => 'inactive'],
            ['name' => 'Anita Desai', 'email' => 'anita@gmail.com', 'status' => 'active'],
            ['name' => 'Vikram Singh', 'email' => 'vikram@gmail.com', 'status' => 'inactive'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
