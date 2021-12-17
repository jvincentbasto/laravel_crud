<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(5,true),
            'author' => $this->faker->name(),
            'published' => $this->faker->date('Y_m_d'),
            'synopsis' => $this->faker->paragraphs(3,true),
            'genres' => $this->faker->words(3,true),
            'price' => $this->faker->randomNumber(7),
        ];
    }
}
