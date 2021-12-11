<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CurrencySeeder::class);

        User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password')
        ]);
    }
}
