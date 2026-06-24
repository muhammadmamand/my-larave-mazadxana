<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'demo@mazadxa.com'],
            [
                'name' => 'Demo Bidder',
                'phone' => '+1 555 0100',
                'bio' => 'Passionate collector of luxury watches and fine art. Active bidder on MazadXA since 2024.',
                'password' => Hash::make('password'),
            ]
        );
    }
}
