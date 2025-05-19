<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quiz Attempt Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Quiz Results</h2>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Back to Dashboard
                        </a>
                        <a href="{{ route('quiz.start') }}" class="px-4 py-2 rounded-lg transition bg-blue-500 hover:bg-blue-600 text-white">
                            Start New Quiz
                        </a>
                    </div>
                </div>

                <x-quiz-result :$attempt></x-quiz-result>
            </div>
        </div>
    </div>
</x-layouts.app>
