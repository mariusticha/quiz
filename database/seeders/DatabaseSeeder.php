<?php

namespace Database\Seeders;

use App\Helpers\ImageDownloader;
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
                'image_url' => 'https://www.merkur.de/bilder/2024/04/friedrich-merz-cdu-bundeskanzler-kabinett-politik-91692090.jpg',
            ],
            [
                'name' => 'Lars Klingbeil',
                'job' => 'Vice Chancellor and Minister of Finance',
                'birth_date' => '1978-02-23',
                'political_party' => 'SPD',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/lars-klingbeil-spd-vize-finanzminister-kabinett-merz-91692091.jpg',
            ],
            [
                'name' => 'Alexander Dobrindt',
                'job' => 'Minister of the Interior',
                'birth_date' => '1970-06-07',
                'political_party' => 'CSU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/alexander-dobrindt-csu-innenminister-kabinett-merz-91692092.jpg',
            ],
            [
                'name' => 'Johann Wadephul',
                'job' => 'Minister of Foreign Affairs',
                'birth_date' => '1963-02-10',
                'political_party' => 'CDU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/johann-wadephul-cdu-aussenminister-kabinett-merz-91692093.jpg',
            ],
            [
                'name' => 'Boris Pistorius',
                'job' => 'Minister of Defense',
                'birth_date' => '1960-03-14',
                'political_party' => 'SPD',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/boris-pistorius-spd-verteidigungsminister-kabinett-merz-91692094.jpg',
            ],
            [
                'name' => 'Katherina Reiche',
                'job' => 'Minister of Economy and Energy',
                'birth_date' => '1973-07-16',
                'political_party' => 'CDU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/katherina-reiche-cdu-wirtschaftsministerin-kabinett-merz-91692095.jpg',
            ],
            [
                'name' => 'Dorothee Bär',
                'job' => 'Minister of Research and Technology',
                'birth_date' => '1978-04-19',
                'political_party' => 'CSU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/dorothee-baer-csu-forschungsministerin-kabinett-merz-91692096.jpg',
            ],
            [
                'name' => 'Stefanie Hubig',
                'job' => 'Minister of Justice',
                'birth_date' => '1968-12-15',
                'political_party' => 'SPD',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/stefanie-hubig-spd-justizministerin-kabinett-merz-91692097.jpg',
            ],
            [
                'name' => 'Karin Prien',
                'job' => 'Minister of Education and Family Affairs',
                'birth_date' => '1965-06-26',
                'political_party' => 'CDU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/karin-prien-cdu-bildungsministerin-kabinett-merz-91692098.jpg',
            ],
            [
                'name' => 'Bärbel Bas',
                'job' => 'Minister of Labor and Social Affairs',
                'birth_date' => '1968-05-03',
                'political_party' => 'SPD',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/baerbel-bas-spd-arbeitsministerin-kabinett-merz-91692099.jpg',
            ],
            [
                'name' => 'Karsten Wildberger',
                'job' => 'Minister of Digital Affairs',
                'birth_date' => '1969-09-10',
                'political_party' => 'CDU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/karsten-wildberger-cdu-digitalminister-kabinett-merz-91692100.jpg',
            ],
            [
                'name' => 'Patrick Schnieder',
                'job' => 'Minister of Transport',
                'birth_date' => '1968-05-01',
                'political_party' => 'CDU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/patrick-schnieder-cdu-verkehrsminister-kabinett-merz-91692101.jpg',
            ],
            [
                'name' => 'Carsten Schneider',
                'job' => 'Minister of Environment and Climate',
                'birth_date' => '1976-01-23',
                'political_party' => 'SPD',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/carsten-schneider-spd-umweltminister-kabinett-merz-91692102.jpg',
            ],
            [
                'name' => 'Nina Warken',
                'job' => 'Minister of Health',
                'birth_date' => '1979-05-15',
                'political_party' => 'CDU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/nina-warken-cdu-gesundheitsministerin-kabinett-merz-91692103.jpg',
            ],
            [
                'name' => 'Alois Rainer',
                'job' => 'Minister of Agriculture',
                'birth_date' => '1965-05-25',
                'political_party' => 'CSU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/alois-rainer-csu-landwirtschaftsminister-kabinett-merz-91692104.jpg',
            ],
            [
                'name' => 'Reem Alabali-Radovan',
                'job' => 'Minister of Economic Cooperation and Development',
                'birth_date' => '1990-01-06',
                'political_party' => 'SPD',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/reem-alabali-radovan-spd-entwicklungsministerin-kabinett-merz-91692105.jpg',
            ],
            [
                'name' => 'Verena Hubertz',
                'job' => 'Minister of Housing and Urban Development',
                'birth_date' => '1987-10-07',
                'political_party' => 'SPD',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/verena-hubertz-spd-bauministerin-kabinett-merz-91692106.jpg',
            ],
            [
                'name' => 'Thorsten Frei',
                'job' => 'Chief of Staff',
                'birth_date' => '1973-05-08',
                'political_party' => 'CDU',
                'image_url' => 'https://www.merkur.de/bilder/2024/04/thorsten-frei-cdu-kanzleramtschef-kabinett-merz-91692107.jpg',
            ],
        ];

        foreach ($politicians as $politician) {
            $imageUrl = $politician['image_url'];
            unset($politician['image_url']);

            // Download and store the image
            if (isset($imageUrl)) {
                $filename = strtolower(str_replace(' ', '-', $politician['name'])) . '.jpg';
                $politician['image_path'] = ImageDownloader::downloadImage($imageUrl, $filename);
            }

            Person::create($politician);
        }
    }
}
