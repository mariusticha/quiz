<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizAttemptController extends Controller
{
    public function show(QuizAttempt $attempt)
    {
        // Security check: only allow users to see their own quiz attempts
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to view this quiz attempt.');
        }

        return view('quiz-attempt', [
            'attempt' => $attempt,
            'questions' => $attempt->questions_data['questions'],
            'answers' => $attempt->questions_data['answers'],
            'startTime' => $attempt->completed_at->subSeconds($attempt->time_taken_seconds)
        ]);
    }
}
