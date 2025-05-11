<?php

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('person has required columns', function () {
    $person = Person::factory()->create([
        'name' => 'Test Person',
        'job' => 'Chancellor',
        'birth_date' => '1990-01-01',
        'political_party' => 'Test Party',
    ]);

    expect($person)
        ->name->toBe('Test Person')
        ->job->toBe('Chancellor')
        ->birth_date->toBeInstanceOf(\Carbon\Carbon::class)
        ->political_party->toBe('Test Party')
        ->image_path->toBeNull();
});

test('birth_date is cast to carbon instance', function () {
    $person = Person::factory()->create([
        'birth_date' => '1990-01-01'
    ]);

    expect($person->birth_date)
        ->toBeInstanceOf(\Carbon\Carbon::class)
        ->toDateString()->toBe('1990-01-01');
});

test('person can have optional image path', function () {
    $person = Person::factory()->create([
        'image_path' => '/path/to/image.jpg'
    ]);

    expect($person->image_path)->toBe('/path/to/image.jpg');
});
