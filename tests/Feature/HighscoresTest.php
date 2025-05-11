<?php

use App\Livewire\Highscores;
use App\Models\QuizAttempt;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('highscores can be rendered', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

test('highscores shows empty state when no attempts exist', function () {
    Livewire::test(Highscores::class)
        ->assertSee('No quiz attempts yet');
});

test('highscores displays attempts in correct order', function () {
    $user1 = User::factory()->create(['name' => 'User One']);
    $user2 = User::factory()->create(['name' => 'User Two']);
    
    QuizAttempt::create([
        'user_id' => $user1->id,
        'correct_answers' => 8,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => ['test' => 'data'],
        'completed_at' => now(),
    ]);

    QuizAttempt::create([
        'user_id' => $user2->id,
        'correct_answers' => 10,
        'total_questions' => 10,
        'time_taken_seconds' => 90,
        'questions_data' => ['test' => 'data'],
        'completed_at' => now(),
    ]);

    $component = Livewire::test(Highscores::class);
    $component->assertSee('User Two')
        ->assertSee('10/10')
        ->assertSee('User One')
        ->assertSee('8/10');
});

test('highscores are ordered by correct answers then time', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    // Both users got 8 correct, but user2 was faster
    QuizAttempt::create([
        'user_id' => $user1->id,
        'correct_answers' => 8,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => ['test' => 'data'],
        'completed_at' => now(),
    ]);

    QuizAttempt::create([
        'user_id' => $user2->id,
        'correct_answers' => 8,
        'total_questions' => 10,
        'time_taken_seconds' => 90,
        'questions_data' => ['test' => 'data'],
        'completed_at' => now(),
    ]);

    $component = Livewire::test(Highscores::class);
    $attempts = $component->viewData('highscores');
    
    expect($attempts->first()->time_taken_seconds)->toBe(90)
        ->and($attempts->last()->time_taken_seconds)->toBe(120);
});
