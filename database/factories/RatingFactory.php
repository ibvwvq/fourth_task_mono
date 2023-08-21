<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition()
    {
        $feedbacks = Feedback::all();
        return [
            'numberRating'=> random_int(1,10),
            'user_id' => User::get()->random()->id,
            'product_id' => Product::get()->random()->id,
            'feedback_id'=> $this->faker->unique()->numberBetween(1, $feedbacks->count())
        ];
    }
}
