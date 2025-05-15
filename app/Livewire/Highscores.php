<?php

namespace App\Livewire;

use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Highscores extends Component
{
    public function getHighscores()
    {
        return QuizAttempt::with('user')
            ->orderByDesc('correct_answers')
            ->orderBy('time_taken_seconds')
            ->limit(10)
            ->get();
    }

    public function viewAttempt($attemptId)
    {
        $attempt = QuizAttempt::findOrFail($attemptId);

        // Only allow users to see their own attempts
        if ($attempt->user_id !== Auth::id()) {
            return;
        }

        return redirect()->route('quiz.attempt', ['attempt' => $attemptId]);
    }

    public function render()
    {
        return view('livewire.highscores', [
            'highscores' => $this->getHighscores(),
            'currentUserId' => Auth::id(),
        ]);
    }
}
