<?php

use App\Livewire\Quiz;
use App\Models\Person;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    // Create some test people for the quiz
    Person::factory()->count(3)->create([
        'job' => fn () => fake()->randomElement(['Chancellor', 'Minister', 'Opposition Leader']),
        'political_party' => fn () => fake()->randomElement(['SPD', 'CDU', 'Die Grünen']),
    ]);
});

test('quiz page can be rendered', function () {
    $response = $this->get('/quiz');
    $response->assertStatus(200);
});

test('quiz component can be mounted', function () {
    Livewire::test(Quiz::class)
        ->assertSet('currentQuestionIndex', 0)
        ->assertSet('isComplete', false)
        ->assertSet('showError', false);
});

test('quiz requires answers before proceeding', function () {
    Livewire::test(Quiz::class)
        ->assertSet('currentQuestionIndex', 0)
        ->call('nextQuestion')
        ->assertSet('showError', true)
        ->assertSet('currentQuestionIndex', 0);
});

test('quiz allows navigation after answering', function () {
    $component = Livewire::test(Quiz::class);

    $component
        ->assertSet('currentQuestionIndex', 0)
        ->call('selectAnswer', $component->questions[0]['options'][0])
        ->assertSet('showError', false)
        ->call('nextQuestion')
        ->assertSet('currentQuestionIndex', 1);
});

test('quiz completion creates attempt record', function () {
    $component = Livewire::test(Quiz::class);

    // Answer all questions
    foreach (range(0, count($component->questions) - 1) as $index) {
        $component->call('selectAnswer', $component->questions[$index]['options'][0]);
        if ($index < count($component->questions) - 1) {
            $component->call('nextQuestion');
        }
    }

    $this->assertDatabaseCount('quiz_attempts', 0);

    $component->call('completeQuiz')
        ->assertRedirect(route('quiz.attempt', [
            'attempt' => 1,
        ]));

    $this->assertDatabaseCount('quiz_attempts', 1);

    $this->assertDatabaseHas('quiz_attempts', [
        'user_id' => $this->user->id,
        'total_questions' => count($component->questions),
    ]);
});

test('quiz prevents completion with unanswered questions', function () {
    $component = Livewire::test(Quiz::class);

    $component
        ->assertSet('currentQuestionIndex', 0)
        ->call('completeQuiz')
        ->assertSet('showError', true)
        ->assertSet('isComplete', false);
});
