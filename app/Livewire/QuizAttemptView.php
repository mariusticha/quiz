<?php

namespace App\Livewire;

use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuizAttemptView extends Component
{
    public $attempt;
    public $questions;
    public $answers;
    public $startTime;
    public $isComplete = true;

    public function mount(QuizAttempt $attempt)
    {
        // Security check: only allow users to see their own quiz attempts
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to view this quiz attempt.');
        }

        $this->attempt = $attempt;

        // Extract questions and answers from the stored JSON data
        $this->questions = $attempt->questions_data['questions'];
        $this->answers = $attempt->questions_data['answers'];

        // Mock startTime for view compatibility
        $this->startTime = $attempt->completed_at->subSeconds($attempt->time_taken_seconds);
    }

    public function render()
    {
        return view('livewire.quiz-attempt-view')
            ->layout('layouts.app', [
                'header' => 'Quiz Attempt Details'
            ]);
    }
}
