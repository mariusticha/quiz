<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create additional random users
        User::factory(3)->create();

        // Create real German politicians
        $politicians = [
            [
                'name' => 'Olaf Scholz',
                'job' => 'Chancellor',
                'birth_date' => '1958-06-14',
                'political_party' => 'SPD',
            ],
            [
                'name' => 'Friedrich Merz',
                'job' => 'Opposition Leader',
                'birth_date' => '1955-11-11',
                'political_party' => 'CDU',
            ],
            [
                'name' => 'Annalena Baerbock',
                'job' => 'Minister of Foreign Affairs',
                'birth_date' => '1980-12-15',
                'political_party' => 'Die Grünen',
            ],
            [
                'name' => 'Christian Lindner',
                'job' => 'Minister of Finance',
                'birth_date' => '1979-01-07',
                'political_party' => 'FDP',
            ],
            [
                'name' => 'Robert Habeck',
                'job' => 'Minister of Economic Affairs',
                'birth_date' => '1969-09-02',
                'political_party' => 'Die Grünen',
            ],
            [
                'name' => 'Nancy Faeser',
                'job' => 'Minister of the Interior',
                'birth_date' => '1970-07-13',
                'political_party' => 'SPD',
            ],
            [
                'name' => 'Karl Lauterbach',
                'job' => 'Minister of Health',
                'birth_date' => '1963-02-21',
                'political_party' => 'SPD',
            ],
            [
                'name' => 'Boris Pistorius',
                'job' => 'Minister of Defense',
                'birth_date' => '1960-03-14',
                'political_party' => 'SPD',
            ],
            [
                'name' => 'Markus Söder',
                'job' => 'Minister President of Bavaria',
                'birth_date' => '1967-01-05',
                'political_party' => 'CSU',
            ],
            [
                'name' => 'Saskia Esken',
                'job' => 'Party Co-Leader',
                'birth_date' => '1961-08-28',
                'political_party' => 'SPD',
            ],
        ];

        foreach ($politicians as $politician) {
            Person::create($politician);
        }
    }
}
