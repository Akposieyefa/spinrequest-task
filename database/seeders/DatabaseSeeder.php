<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Orutu Akposieyefa Williams',
             'email' => 'orutu1@gmail.com',
             'email_verified_at' => now(),
             'password' => 'password',
             'remember_token' => str()->random(10),
         ]);
    }
}
