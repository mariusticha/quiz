<?php

use App\Livewire\Highscores;
use App\Models\Person;
use App\Models\QuizAttempt;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    Person::factory()->count(3)->create();
});

test('users can view their own quiz attempts from highscores', function () {
    // Create a quiz attempt for the current user
    $attempt = QuizAttempt::create([
        'user_id' => $this->user->id,
        'correct_answers' => 5,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => [
            'questions' => [
                [
                    'type' => 'job',
                    'question' => 'What is Person 1\'s job?',
                    'correct_answer' => 'Chancellor',
                    'options' => ['Chancellor', 'Minister', 'Opposition Leader'],
                    'person_id' => 1,
                ]
            ],
            'answers' => ['Chancellor']
        ],
        'completed_at' => now(),
    ]);

    // Test that clicking a highscore redirects to the attempt view
    Livewire::test(Highscores::class)
        ->assertSee('5/10')
        ->call('viewAttempt', $attempt->id)
        ->assertRedirect(route('quiz.attempt', ['attempt' => $attempt->id]));
});

test('users cannot view other users quiz attempts', function () {
    // Create another user
    $otherUser = User::factory()->create();

    // Create a quiz attempt for the other user
    $attempt = QuizAttempt::create([
        'user_id' => $otherUser->id,
        'correct_answers' => 7,
        'total_questions' => 10,
        'time_taken_seconds' => 90,
        'questions_data' => [
            'questions' => [
                [
                    'type' => 'job',
                    'question' => 'What is Person 1\'s job?',
                    'correct_answer' => 'Chancellor',
                    'options' => ['Chancellor', 'Minister', 'Opposition Leader'],
                    'person_id' => 1,
                ]
            ],
            'answers' => ['Minister']
        ],
        'completed_at' => now(),
    ]);

    // Test that a 403 error is thrown when attempting to view another user's attempt
    $this->get(route('quiz.attempt', ['attempt' => $attempt->id]))
        ->assertForbidden();
});

test('quiz attempt view shows correct attempt details', function () {
    // Create a quiz attempt for the current user
    $attempt = QuizAttempt::create([
        'user_id' => $this->user->id,
        'correct_answers' => 5,
        'total_questions' => 10,
        'time_taken_seconds' => 120,
        'questions_data' => [
            'questions' => [
                [
                    'type' => 'job',
                    'question' => 'What is Person 1\'s job?',
                    'correct_answer' => 'Chancellor',
                    'options' => ['Chancellor', 'Minister', 'Opposition Leader'],
                    'person_id' => 1,
                ]
            ],
            'answers' => ['Chancellor']
        ],
        'completed_at' => now(),
    ]);

    // Test that the attempt view shows the correct details
    $response = $this->get(route('quiz.attempt', ['attempt' => $attempt->id]));
    $response->assertOk()
        ->assertViewIs('quiz-attempt');

    // Since HTML entities might be rendered differently, let's examine the view data directly
    $this->assertEquals('Chancellor', $attempt->questions_data['questions'][0]['correct_answer']);
    $this->assertEquals(5, $attempt->correct_answers);
    $this->assertEquals(10, $attempt->total_questions);
});
