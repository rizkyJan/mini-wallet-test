<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'usera@mail.com'],
            [
                'name' => 'User A',
                'password' => Hash::make('password'),
                'balance' => 100000,
            ]
        );

        User::firstOrCreate(
            ['email' => 'userb@mail.com'],
            [
                'name' => 'User B',
                'password' => Hash::make('password'),
                'balance' => 100000,
            ]
        );

        User::firstOrCreate(
            ['email' => 'userc@mail.com'],
            [
                'name' => 'User C',
                'password' => Hash::make('password'),
                'balance' => 100000,
            ]
        );
    }
}
