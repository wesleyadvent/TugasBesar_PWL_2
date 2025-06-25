<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = User::create([
          
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'administrator',
            'status' => 'aktif'
        ]);

        $keuangan = User::create([
          
            'name' => 'Keuangan',
            'email' => 'keuangan@example.com',
            'password' => bcrypt('keuangan123'),
            'role' => 'keuangan',
            'status' => 'aktif'
        ]);

        $panitia = User::create([
         
            'name' => 'Panitia',
            'email' => 'panitia@example.com',
            'password' => bcrypt('panitia123'),
            'role' => 'panitia',
            'status' => 'aktif'
        ]);

        $member = User::create([
          
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => bcrypt('member123'),
            'role' => 'member',
            'status' => 'aktif'
        ]);
    }
}
