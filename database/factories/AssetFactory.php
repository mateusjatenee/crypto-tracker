<?php

namespace Database\Factories;

use App\Enums\AssetType;
use App\Models\Asset;
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
            'code' => 'BBDC4'
        ];
    }

    public function crypto()
    {
        return $this->state(function ($state) {
            return [
                'type' => AssetType::CRYPTO,
                'current_price' => rand(100, 50000),
                'code' => array_rand(['ETH', 'BTC', 'SOL'])
            ];
        });
    }
}
