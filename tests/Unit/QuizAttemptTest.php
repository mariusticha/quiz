<?php

use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('quiz attempt has required columns', function () {
    $user = User::factory()->create();
    
    $attempt = QuizAttempt::create([
        'user_id' => $user->id,
        'correct_answers' => 8,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => ['test' => 'data'],
        'completed_at' => now(),
    ]);

    expect($attempt->refresh())
        ->user_id->toBe($user->id)
        ->correct_answers->toBe(8)
        ->total_questions->toBe(10)
        ->time_taken_seconds->toBe(120)
        ->questions_data->toBe(['test' => 'data'])
        ->completed_at->toBeInstanceOf(\Carbon\Carbon::class);
});

test('quiz attempt belongs to a user', function () {
    $user = User::factory()->create();
    
    $attempt = QuizAttempt::create([
        'user_id' => $user->id,
        'correct_answers' => 8,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => ['test' => 'data'],
        'completed_at' => now(),
    ]);

    expect($attempt->user)
        ->toBeInstanceOf(User::class)
        ->id->toBe($user->id);
});

test('questions data is cast to array', function () {
    $user = User::factory()->create();
    
    $questionsData = [
        'questions' => [
            ['question' => 'Test?', 'answer' => 'Test']
        ]
    ];
    
    $attempt = QuizAttempt::create([
        'user_id' => $user->id,
        'correct_answers' => 8,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => $questionsData,
        'completed_at' => now(),
    ]);

    expect($attempt->refresh()->questions_data)
        ->toBe($questionsData)
        ->toBeArray()
        ->questions->toBeArray();
});

test('completed_at is cast to datetime', function () {
    $user = User::factory()->create();
    $now = now();
    
    $attempt = QuizAttempt::create([
        'user_id' => $user->id,
        'correct_answers' => 8,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => ['test' => 'data'],
        'completed_at' => $now,
    ]);

    expect($attempt->refresh()->completed_at)
        ->toBeInstanceOf(\Carbon\Carbon::class)
        ->toDateTimeString()->toBe($now->toDateTimeString());
});
