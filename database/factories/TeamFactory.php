<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use App\Models\Account;
use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            'personal_team' => true,
        ];
    }


    public function withDefaultAccount()
    {
        return $this->has(
            Account::factory()
                ->state(function (array $attributes, Team $team) {
                    return [
                        'name' => 'Default',
                        'type' => AccountType::CRYPTO
                    ];
                }),
            'accounts'
        );
    }
}
