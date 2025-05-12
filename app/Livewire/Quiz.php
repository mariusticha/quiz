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

    private function getRandomOptions($correctAnswer, $allOptions, $count = 3)
    {
        // Get unique options excluding the correct answer
        $availableOptions = $allOptions->where('id', '!=', $correctAnswer['id']);

        // If we have fewer options than requested, use all available options
        $count = min($count, $availableOptions->count());

        return $availableOptions
            ->shuffle()
            ->take($count)
            ->push($correctAnswer)
            ->shuffle()
            ->values();
    }

    private function prepareQuestions()
    {
        $persons = Person::all();
        $questions = collect();

        foreach ($persons as $person) {
            // Get other persons for multiple choice options
            $otherPersons = $persons->where('id', '!=', $person->id);

            // Get other jobs (excluding current person's job)
            $otherJobs = $otherPersons->map(fn($p) => [
                'id' => $p->id,
                'value' => $p->job
            ])->unique('value');

            $jobOptions = $this->getRandomOptions(
                ['id' => $person->id, 'value' => $person->job],
                $otherJobs
            )->pluck('value');

            // For parties, get all unique parties and remove the current person's party
            $allParties = $persons->pluck('political_party')->unique();
            $partyOptions = $allParties
                ->filter(fn($party) => $party !== $person->political_party)
                ->push($person->political_party)
                ->shuffle()
                ->values();

            // Regular text questions
            $questions->push([
                'type' => 'job',
                'question' => "What is {$person->name}'s job?",
                'correct_answer' => $person->job,
                'options' => $jobOptions,
                'person_id' => $person->id,
            ]);

            // Only add party question if we have more than 1 party option
            if ($partyOptions->count() > 1) {
                $questions->push([
                    'type' => 'party',
                    'question' => "Which political party does {$person->name} belong to?",
                    'correct_answer' => $person->political_party,
                    'options' => $partyOptions,
                    'person_id' => $person->id,
                ]);
            }

            // Image-based questions
            if ($person->image_path) {
                // Get other persons for image questions (ensuring they have images)
                $otherPersonsWithImages = $otherPersons->filter(fn($p) => !empty($p->image_path));

                // Only create image questions if we have enough other images
                if ($otherPersonsWithImages->count() >= 2) {
                    // For image selections, map the full person object to keep all needed data
                    $imagePersonOptions = $this->getRandomOptions(
                        ['id' => $person->id, 'value' => $person],
                        $otherPersonsWithImages->map(fn($p) => [
                            'id' => $p->id,
                            'value' => $p
                        ]),
                        min(3, $otherPersonsWithImages->count()) // Limit to available unique images
                    )->pluck('value');

                    // Question: Select correct image for a name
                    $questions->push([
                        'type' => 'select_image',
                        'question' => "Select the image of {$person->name}",
                        'correct_answer' => $person->image_path,
                        'options' => $imagePersonOptions->pluck('image_path'),
                        'person_id' => $person->id,
                    ]);

                    // Question: Select correct name for an image
                    $questions->push([
                        'type' => 'identify_person',
                        'question' => 'Who is this person?',
                        'image' => $person->image_path,
                        'correct_answer' => $person->name,
                        'options' => $imagePersonOptions->pluck('name'),
                        'person_id' => $person->id,
                    ]);

                    // Question: Select correct job for an image
                    $questions->push([
                        'type' => 'identify_job',
                        'question' => 'What is this person\'s job?',
                        'image' => $person->image_path,
                        'correct_answer' => $person->job,
                        'options' => $jobOptions,
                        'person_id' => $person->id,
                    ]);
                }
            }
        }

        $this->questions = $questions->shuffle()->values()->all();
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
