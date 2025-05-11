<?php

namespace App\Livewire;

use App\Models\Person;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Quiz extends Component
{
    public $currentQuestionIndex = 0;
    public $questions;
    public $answers = [];
    public $startTime;
    public $isComplete = false;
    public $showError = false;

    public function mount()
    {
        $this->startTime = now();
        $this->prepareQuestions();
    }

    private function prepareQuestions()
    {
        $persons = Person::all();
        $questions = collect();

        foreach ($persons as $person) {
            // Get 3 other random persons for multiple choice options
            $otherPersons = $persons->where('id', '!=', $person->id)->random(3);

            // Create different types of questions for this person
            $questions->push([
                'type' => 'job',
                'question' => "What is {$person->name}'s job?",
                'correct_answer' => $person->job,
                'options' => $otherPersons->pluck('job')->push($person->job)->shuffle()->values()->all(),
                'person_id' => $person->id,
            ]);

            $questions->push([
                'type' => 'party',
                'question' => "Which political party does {$person->name} belong to?",
                'correct_answer' => $person->political_party,
                'options' => $otherPersons->pluck('political_party')->push($person->political_party)->shuffle()->values()->all(),
                'person_id' => $person->id,
            ]);
        }

        $this->questions = $questions->shuffle()->values()->all();
        // Initialize empty answers array
        $this->answers = array_fill(0, count($this->questions), null);
    }

    public function selectAnswer($answer)
    {
        $this->answers[$this->currentQuestionIndex] = $answer;
        $this->showError = false;
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->showError = false;
        }
    }

    public function nextQuestion()
    {
        if ($this->answers[$this->currentQuestionIndex] === null) {
            $this->showError = true;
            return;
        }

        if ($this->currentQuestionIndex + 1 < count($this->questions)) {
            $this->currentQuestionIndex++;
            $this->showError = false;
        }
    }

    public function completeQuiz()
    {
        // Check if any questions are unanswered
        if (in_array(null, $this->answers, true)) {
            $this->showError = true;
            return;
        }

        $this->isComplete = true;
        $correctAnswers = collect($this->answers)->filter(
            fn($answer, $index) =>
            $answer === $this->questions[$index]['correct_answer']
        )->count();

        QuizAttempt::create([
            'user_id' => Auth::id(),
            'correct_answers' => $correctAnswers,
            'total_questions' => count($this->questions),
            'time_taken_seconds' => now()->diffInSeconds($this->startTime),
            'questions_data' => [
                'questions' => $this->questions,
                'answers' => $this->answers,
            ],
            'completed_at' => now(),
        ]);
    }

    public function render()
    {
        return view('livewire.quiz');
    }
}
