<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'name' => 'Brazilian Real',
            'code' => 'BRL'
        ]);

        Currency::create([
            'name' => 'U.S Dollar',
            'code' => 'USD'
        ]);
    }
}
