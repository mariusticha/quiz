<div class="max-w-4xl mx-auto p-4">
    @if (!$isComplete)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="mb-4">
                <span class="text-gray-600 dark:text-gray-400">Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}</span>
            </div>

            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
                {{ $questions[$currentQuestionIndex]['question'] }}
            </h2>

            <div class="grid grid-cols-1 gap-4">
                @foreach ($questions[$currentQuestionIndex]['options'] as $option)
                    <button
                        wire:click="submitAnswer('{{ $option }}')"
                        class="p-4 text-left border rounded-lg text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition bg-white dark:bg-gray-800"
                    >
                        {{ $option }}
                    </button>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Quiz Complete!</h2>
            <div class="space-y-4">
                <p class="text-lg text-gray-700 dark:text-gray-300">
                    You got {{ collect($answers)->filter(fn ($answer) => $answer['given_answer'] === $answer['correct_answer'])->count() }}
                    out of {{ count($questions) }} questions correct!
                </p>
                <p class="text-gray-600 dark:text-gray-400">
                    Time taken: {{ now()->diffInSeconds($startTime) }} seconds
                </p>
                <a href="{{ route('quiz.start') }}"
                   class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Start New Quiz
                </a>
            </div>
        </div>
    @endif
</div>
