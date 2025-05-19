<?php

namespace App\Http\Controllers;

use App\Livewire\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;

class QuizAttemptController extends Controller
{
    public function __invoke(QuizAttempt $attempt)
    {
        // Security check: only allow users to see their own quiz attempts
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to view this quiz attempt.');
        }

        return view('quiz-attempt', [
            'attempt' => $attempt,
        ]);
    }
}
