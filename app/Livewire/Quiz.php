<?php

namespace App\Livewire;

use App\Models\Person;
use App\Models\QuizAttempt;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Quiz extends Component
{
    public int $currentQuestionIndex = 0;

    public array $questions;

    public array $answers = [];

    public Carbon $startTime;

    public bool $showError = false;

    private ?int $limit = null;

    public function mount(): void
    {
        $this->startTime = now();

        $this->prepareQuestions();

        if ($this->limit) {
            $this->questions = array_slice($this->questions, 0, $this->limit);

            $this->answers = array_slice($this->answers, 0, $this->limit);
        }
    }

    private function getRandomOptions($correctAnswer, $allOptions, $count = 3): Collection
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

    private function getQuestionForPerson(Person $person, $persons, $questionType = null)
    {
        $otherPersons = $persons->where('id', '!=', $person->id);

        // Get all possible question types for this person
        $availableTypes = ['job'];  // Job question is always available

        // Party question available if we have more than one unique party
        $uniqueParties = $persons->pluck('political_party')->unique();
        if ($uniqueParties->count() > 1) {
            $availableTypes[] = 'party';
        }

        // Image questions available if person has image and we have enough other images
        if ($person->image_path) {
            $otherPersonsWithImages = $otherPersons->filter(fn ($p) => ! empty($p->image_path));
            if ($otherPersonsWithImages->count() >= 2) {
                $availableTypes = array_merge($availableTypes, ['select_image', 'identify_person', 'identify_job']);
            }
        }

        // Use provided question type or randomly select one
        $type = $questionType ?? $availableTypes[array_rand($availableTypes)];

        switch ($type) {
            case 'party':
                $options = $uniqueParties
                    ->filter(fn ($party) => $party !== $person->political_party)
                    ->push($person->political_party)
                    ->shuffle()
                    ->values();

                return [
                    'type' => 'party',
                    'question' => "Which political party does {$person->name} belong to?",
                    'correct_answer' => $person->political_party,
                    'options' => $options,
                    'person_id' => $person->id,
                ];

            case 'select_image':
                $imageOptions = $this->getRandomOptions(
                    ['id' => $person->id, 'value' => $person],
                    $otherPersonsWithImages->map(fn ($p) => [
                        'id' => $p->id,
                        'value' => $p,
                    ]),
                    min(3, $otherPersonsWithImages->count())
                )->pluck('value');

                return [
                    'type' => 'select_image',
                    'question' => "Select the image of {$person->name}",
                    'correct_answer' => $person->image_path,
                    'options' => $imageOptions->pluck('image_path'),
                    'person_id' => $person->id,
                ];

            case 'identify_person':
                $imageOptions = $this->getRandomOptions(
                    ['id' => $person->id, 'value' => $person],
                    $otherPersonsWithImages->map(fn ($p) => [
                        'id' => $p->id,
                        'value' => $p,
                    ]),
                    min(3, $otherPersonsWithImages->count())
                )->pluck('value');

                return [
                    'type' => 'identify_person',
                    'question' => 'Who is this person?',
                    'image' => $person->image_path,
                    'correct_answer' => $person->name,
                    'options' => $imageOptions->pluck('name'),
                    'person_id' => $person->id,
                ];

            case 'identify_job':
            default:
                $otherJobs = $otherPersons->map(fn ($p) => [
                    'id' => $p->id,
                    'value' => $p->job,
                ])->unique('value');

                $jobOptions = $this->getRandomOptions(
                    ['id' => $person->id, 'value' => $person->job],
                    $otherJobs
                )->pluck('value');

                return [
                    'type' => 'identify_job',
                    'question' => $type === 'identify_job'
                        ? ('What is the role of the person in this image?')
                        : ("What is {$person->name}'s job?"),
                    'image' => $type === 'identify_job' ? $person->image_path : null,
                    'correct_answer' => $person->job,
                    'options' => $jobOptions,
                    'person_id' => $person->id,
                ];
        }
    }

    private function prepareQuestions()
    {
        $persons = Person::all();

        $questions = collect();

        // Create one question for each person with a random question type
        foreach ($persons as $person) {
            $questions->push($this->getQuestionForPerson($person, $persons));
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

        $correctAnswers = collect($this->answers)->filter(
            fn ($answer, $index) => $answer === $this->questions[$index]['correct_answer']
        )->count();

        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'correct_answers' => $correctAnswers,
            'total_questions' => count($this->questions),
            'time_taken_seconds' => $this->startTime->diffInSeconds(now()),
            'questions_data' => [
                'questions' => $this->questions,
                'answers' => $this->answers,
            ],
            'completed_at' => now(),
        ]);

        return redirect()->route('quiz.attempt', [
            'attempt' => $attempt,
        ]);
    }

    public function render()
    {
        return view('livewire.quiz');
    }
}
