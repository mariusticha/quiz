<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    public function definition(): array
    {
        $politicalParties = [
            'CDU',
            'SPD',
            'Die Grünen',
            'FDP',
            'Die Linke',
            'AfD',
        ];

        $jobs = [
            'Chancellor',
            'Minister of Finance',
            'Minister of Foreign Affairs',
            'Minister of Health',
            'Minister of Defense',
            'Opposition Leader',
            'Member of Parliament',
            'State Premier',
        ];

        return [
            'name' => fake()->name(),
            'job' => fake()->randomElement($jobs),
            'birth_date' => fake()->dateTimeBetween('-80 years', '-30 years'),
            'political_party' => fake()->randomElement($politicalParties),
        ];
    }
}
