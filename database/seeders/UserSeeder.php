<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin1 = User::create([
            'name' => 'Admin Rizki',
            'email' => 'muhammad.rizki3405@student.unri.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $admin1->assignrole('admin');

        $admin2 = User::create([
            'name' => 'Admin Dwi',
            'email' => 'dwi.nurindah0672@student.unri.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $admin2->assignrole('admin');

        $user = User::create([
            'name' => 'User Testing',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignrole('user');

        
    }
}
