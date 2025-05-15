<div class="space-y-6">
    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
        <p class="text-lg text-gray-700 dark:text-gray-300">
            {{ isset($attempt) ? 'Score: ' . $attempt->correct_answers : 'You got ' . collect($answers)->filter(fn ($answer, $index) => $answer === $questions[$index]['correct_answer'])->count() }}
            out of {{ isset($attempt) ? $attempt->total_questions : count($questions) }} questions correct!
        </p>
        <p class="text-gray-600 dark:text-gray-400 mt-2">
            Time taken: {{ isset($attempt) ? $attempt->time_taken_seconds : now()->diffInSeconds($startTime) }} seconds
        </p>
        @if(isset($attempt))
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Completed on: {{ $attempt->completed_at->format('F j, Y \a\t g:i a') }}
            </p>
        @endif
    </div>

    <div class="space-y-4">
        @foreach ($questions as $index => $question)
            <div @class([
                'p-4 rounded-lg border',
                'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' => $answers[$index] === $question['correct_answer'],
                'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' => $answers[$index] !== $question['correct_answer'],
            ])>
                <div class="flex items-start gap-4">
                    @if (isset($question['image']))
                        <img src="{{ Storage::url($question['image']) }}"
                             alt="Question image"
                             class="w-32 h-32 object-cover rounded-lg">
                    @endif
                    <div class="flex-1">
                        <h3 class="font-semibold mb-2 text-gray-900 dark:text-white">
                            {{ $question['question'] }}
                        </h3>
                        <div class="space-y-1">
                            <p @class([
                                'text-sm',
                                'text-green-600 dark:text-green-400' => $answers[$index] === $question['correct_answer'],
                                'text-red-600 dark:text-red-400' => $answers[$index] !== $question['correct_answer'],
                            ])>
                                Your answer:
                                @if ($question['type'] === 'select_image')
                                    <img src="{{ Storage::url($answers[$index]) }}"
                                         alt="Your answer"
                                         class="w-24 h-24 object-cover rounded-lg mt-2">
                                @else
                                    {{ $answers[$index] }}
                                @endif
                            </p>
                            @if ($answers[$index] !== $question['correct_answer'])
                                <p class="text-sm text-green-600 dark:text-green-400">
                                    Correct answer:
                                    @if ($question['type'] === 'select_image')
                                        <img src="{{ Storage::url($question['correct_answer']) }}"
                                             alt="Correct answer"
                                             class="w-24 h-24 object-cover rounded-lg mt-2">
                                    @else
                                        {{ $question['correct_answer'] }}
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-6">
        <a href="{{ route('quiz.start') }}"
           class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition">
            Start New Quiz
        </a>
    </div>
</div>
