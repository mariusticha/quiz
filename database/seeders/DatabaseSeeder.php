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

        // Create real German politicians (Kabinett Merz, as of May 6, 2025)
        $politicians = [
            [
                'name' => 'Friedrich Merz',
                'job' => 'Chancellor',
                'birth_date' => '1955-11-11',
                'political_party' => 'CDU',
                'image_path' => 'politicians/friedrich-merz.jpg',
            ],
            [
                'name' => 'Lars Klingbeil',
                'job' => 'Vice Chancellor and Minister of Finance',
                'birth_date' => '1978-02-23',
                'political_party' => 'SPD',
                'image_path' => 'politicians/lars-klingbeil.jpg',
            ],
            [
                'name' => 'Alexander Dobrindt',
                'job' => 'Minister of the Interior',
                'birth_date' => '1970-06-07',
                'political_party' => 'CSU',
                'image_path' => 'politicians/alexander-dobrindt.jpg',
            ],
            [
                'name' => 'Johann Wadephul',
                'job' => 'Minister of Foreign Affairs',
                'birth_date' => '1963-02-10',
                'political_party' => 'CDU',
                'image_path' => 'politicians/johann-wadephul.jpg',
            ],
            [
                'name' => 'Boris Pistorius',
                'job' => 'Minister of Defense',
                'birth_date' => '1960-03-14',
                'political_party' => 'SPD',
                'image_path' => 'politicians/boris-pistorius.jpg',
            ],
            [
                'name' => 'Katherina Reiche',
                'job' => 'Minister of Economy and Energy',
                'birth_date' => '1973-07-16',
                'political_party' => 'CDU',
                'image_path' => 'politicians/katherina-reiche.jpg',
            ],
            [
                'name' => 'Dorothee Bär',
                'job' => 'Minister of Research and Technology',
                'birth_date' => '1978-04-19',
                'political_party' => 'CSU',
                'image_path' => 'politicians/dorothee-baer.jpg',
            ],
            [
                'name' => 'Stefanie Hubig',
                'job' => 'Minister of Justice',
                'birth_date' => '1968-12-15',
                'political_party' => 'SPD',
                'image_path' => 'politicians/stefanie-hubig.jpg',
            ],
            [
                'name' => 'Karin Prien',
                'job' => 'Minister of Education and Family Affairs',
                'birth_date' => '1965-06-26',
                'political_party' => 'CDU',
                'image_path' => 'politicians/karin-prien.jpg',
            ],
            [
                'name' => 'Bärbel Bas',
                'job' => 'Minister of Labor and Social Affairs',
                'birth_date' => '1968-05-03',
                'political_party' => 'SPD',
                'image_path' => 'politicians/baerbel-bas.jpg',
            ],
            [
                'name' => 'Karsten Wildberger',
                'job' => 'Minister of Digital Affairs',
                'birth_date' => '1969-09-10',
                'political_party' => 'CDU',
                'image_path' => 'politicians/karsten-wildberger.jpg',
            ],
            [
                'name' => 'Patrick Schnieder',
                'job' => 'Minister of Transport',
                'birth_date' => '1968-05-01',
                'political_party' => 'CDU',
                'image_path' => 'politicians/patrick-schnieder.jpg',
            ],
            [
                'name' => 'Carsten Schneider',
                'job' => 'Minister of Environment and Climate',
                'birth_date' => '1976-01-23',
                'political_party' => 'SPD',
                'image_path' => 'politicians/carsten-schneider.jpg',
            ],
            [
                'name' => 'Nina Warken',
                'job' => 'Minister of Health',
                'birth_date' => '1979-05-15',
                'political_party' => 'CDU',
                'image_path' => 'politicians/nina-warken.jpg',
            ],
            [
                'name' => 'Alois Rainer',
                'job' => 'Minister of Agriculture',
                'birth_date' => '1965-05-25',
                'political_party' => 'CSU',
                'image_path' => 'politicians/alois-rainer.jpg',
            ],
            [
                'name' => 'Reem Alabali-Radovan',
                'job' => 'Minister of Economic Cooperation and Development',
                'birth_date' => '1990-01-06',
                'political_party' => 'SPD',
                'image_path' => 'politicians/reem-alabali-radovan.jpg',
            ],
            [
                'name' => 'Verena Hubertz',
                'job' => 'Minister of Housing and Urban Development',
                'birth_date' => '1987-10-07',
                'political_party' => 'SPD',
                'image_path' => 'politicians/verena-hubertz.jpg',
            ],
            [
                'name' => 'Thorsten Frei',
                'job' => 'Chief of Staff',
                'birth_date' => '1973-05-08',
                'political_party' => 'CDU',
                'image_path' => 'politicians/thorsten-frei.jpg',
            ],
        ];

        foreach ($politicians as $politician) {
            Person::create($politician);
        }
    }
}
