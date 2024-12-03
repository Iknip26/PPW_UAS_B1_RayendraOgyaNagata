<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menghindari duplikasi data dengan firstOrCreate()
        User::firstOrCreate(
            ['email' => 'admin@mail.com'], // Syarat pencarian
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Pastikan password terenkripsi
            ]
        );
    }
}