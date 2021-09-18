<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Currency;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'team_id' => Team::factory(),
            'currency_id' => Currency::factory()
        ];
    }
}
