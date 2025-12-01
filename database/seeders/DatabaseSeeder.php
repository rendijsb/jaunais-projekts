<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate([
            User::NAME => 'Administrator',
            User::EMAIL => 'test@admin.com',
            User::PASSWORD => Hash::make('123qwe@W'),
        ]);
    }
}
