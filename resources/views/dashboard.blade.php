<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Welcome to the Quiz App!</h3>

                    <div class="space-y-4">
                        <p class="text-gray-700 dark:text-gray-300">Test your knowledge about various personalities.</p>

                        <div>
                            <a href="{{ route('quiz.start') }}"
                               class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 dark:hover:bg-blue-400 transition">
                                Start a New Quiz
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <livewire:highscores />
        </div>
    </div>
</x-layouts.app>
