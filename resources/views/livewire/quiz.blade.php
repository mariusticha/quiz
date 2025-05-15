<div class="max-w-4xl mx-auto p-4">
    @if (!$isComplete)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="mb-4 flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}</span>
                <div class="flex items-center space-x-2">
                    <button
                        wire:click="previousQuestion"
                        @class([
                            'px-4 py-2 rounded-lg transition',
                            'bg-blue-500 hover:bg-blue-600 text-white' => $currentQuestionIndex > 0,
                            'bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' => $currentQuestionIndex === 0,
                        ])
                        {{ $currentQuestionIndex === 0 ? 'disabled' : '' }}
                    >
                        Previous
                    </button>
                    <button
                        wire:click="{{ $currentQuestionIndex + 1 < count($questions) ? 'nextQuestion' : 'completeQuiz' }}"
                        @class([
                            'px-4 py-2 rounded-lg transition',
                            'bg-blue-500 hover:bg-blue-600 text-white' => !$showError,
                            'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' => $showError,
                        ])
                    >
                        {{ $currentQuestionIndex + 1 < count($questions) ? 'Next' : 'Complete Quiz' }}
                    </button>
                </div>
            </div>

            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
                {{ $questions[$currentQuestionIndex]['question'] }}
            </h2>

            @if ($showError)
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg">
                    Please select an answer before proceeding.
                </div>
            @endif

            {{-- Display question image if it's an identify type question --}}
            @if (isset($questions[$currentQuestionIndex]['image']))
                <div class="mb-6">
                    <img src="{{ Storage::url($questions[$currentQuestionIndex]['image']) }}"
                         alt="Person to identify"
                         class="max-w-md mx-auto rounded-lg shadow-lg">
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($questions[$currentQuestionIndex]['options'] as $option)
                    <button
                        wire:click="selectAnswer('{{ $option }}')"
                        @class([
                            'p-4 text-left border rounded-lg transition',
                            'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' => $answers[$currentQuestionIndex] !== $option,
                            'bg-blue-100 dark:bg-blue-800/50 text-blue-700 dark:text-blue-100 border-blue-500 ring-2 ring-blue-500 dark:ring-blue-400' => $answers[$currentQuestionIndex] === $option,
                        ])
                    >
                        @if ($questions[$currentQuestionIndex]['type'] === 'select_image')
                            <img src="{{ Storage::url($option) }}"
                                 alt="Politician"
                                 class="w-full rounded-lg">
                        @else
                            {{ $option }}
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Quiz Complete!</h2>
            @include('partials.quiz-results')
            </div>
        </div>
    @endif
</div>
