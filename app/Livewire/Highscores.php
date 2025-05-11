<?php

namespace App\Livewire;

use App\Models\QuizAttempt;
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

    public function render()
    {
        return view('livewire.highscores', [
            'highscores' => $this->getHighscores(),
        ]);
    }
}
