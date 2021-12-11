<?php

namespace Database\Factories;

use App\Enums\PositionAggregateType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionAggregateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => rand(1, 10),
            'asset_unitary_price' => rand(1, 10),
            'profit' => 0,
            'type' => PositionAggregateType::ASSET,
            'account_id' => fn () => AccountFactory::new()->create()->id,
            'asset_id' => fn () => AssetFactory::new()->create()->id,
            'date' => today()
        ];
    }
}
