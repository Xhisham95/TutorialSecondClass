<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class StudentSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'UserName' => 'student1',
            'Email' => 'student1@example.com',
            'password' => bcrypt('password123'),
            'Role' => 'student',
            'Program' => 'Computer Science',
        ]);
    }
}
