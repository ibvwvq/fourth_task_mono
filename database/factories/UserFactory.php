<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition()
    {
        $cities = [
            'Samara',
            'Volgograd',
            'Moscow'
        ];
        return [
            'nameUser' => $this->faker->firstName(),
            'surnameUser' => $this->faker->lastName(),
            'cityUser'=> $cities[random_int(0,2)]
        ];
    }
}
