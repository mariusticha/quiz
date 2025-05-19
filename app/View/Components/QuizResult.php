<?php

namespace App\View\Components;

use App\Models\QuizAttempt;
use Illuminate\View\Component;
use Illuminate\View\View;

class QuizResult extends Component
{
    public function __construct(
        private QuizAttempt $attempt,
    ) {}

    public function render(): View
    {
        $answers = $this->attempt->questions_data['answers'];

        $questions = $this->attempt->questions_data['questions'];

        $correctAnswersCount = collect($answers)
            ->filter(fn (string $answer, int $index) => $answer === $questions[$index]['correct_answer'])
            ->count();

        $startTime = $this->attempt->completed_at->subSeconds($this->attempt->time_taken_seconds);

        return view('components.quiz-result', [
            'attempt' => $this->attempt,
            'correctAnswersCount' => $correctAnswersCount,
            'questions' => $questions,
            'answers' => $answers,
            'startTime' => $startTime,
        ]);
    }
}
