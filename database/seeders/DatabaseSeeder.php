<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'User A',
            'email' => 'usera@mail.com',
            'password' => Hash::make('password'),
            'balance' => 100000,
        ]);

        User::create([
            'name' => 'User B',
            'email' => 'userb@mail.com',
            'password' => Hash::make('password'),
            'balance' => 100000,
        ]);

        User::create([
            'name' => 'User C',
            'email' => 'userc@mail.com',
            'password' => Hash::make('password'),
            'balance' => 100000,
        ]);
    }
}
