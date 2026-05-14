<div class="mx-auto max-w-2xl">
    <h1 class="mb-8 text-2xl font-bold">Practice Test</h1>

    @php
        $pct      = $totalQuestions > 0 ? round(($currentIndex / $totalQuestions) * 100) : 0;
        $question = $questions[$currentIndex] ?? null;
    @endphp

    <div class="mb-6">
        <div class="mb-1 flex justify-between text-sm text-zinc-500">
            <span>Question {{ $currentIndex + 1 }} of {{ $totalQuestions }}</span>
            <span>{{ $pct }}%</span>
        </div>
        <div class="h-2 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">
            <div class="h-2 rounded-full bg-primary transition-all" style="width: {{ $pct }}%"></div>
        </div>
    </div>

    @if ($question)
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            @if ($question->image_path)
                <img src="{{ Storage::url($question->image_path) }}" alt="Question image" class="mb-4 w-full rounded-xl object-cover">
            @endif

            <p class="mb-6 text-lg font-medium text-zinc-900 dark:text-white">{{ $question->question_text }}</p>

            <div class="space-y-3">
                @foreach ($question->answers as $answer)
                    <label wire:key="{{ $answer->id }}"
                           class="flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition
                        {{ $selectedAnswer === $answer->id ? 'border-primary bg-primary/5' : 'border-zinc-200 hover:border-primary/50 dark:border-zinc-700' }}">
                        <input type="radio" wire:model="selectedAnswer" value="{{ $answer->id }}" class="accent-primary">
                        <span class="text-zinc-800 dark:text-zinc-100">{{ $answer->answer_text }}</span>
                    </label>
                @endforeach
            </div>

            @error('selectedAnswer')
                <p class="mt-3 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex justify-end">
            <flux:button
                wire:click="submitAnswer"
                wire:loading.attr="disabled"
                variant="primary"
                icon-trailing="arrow-right"
            >
                <span wire:loading.remove wire:target="submitAnswer">
                    {{ $currentIndex + 1 === $totalQuestions ? 'Finish Test' : 'Next Question' }}
                </span>
                <span wire:loading wire:target="submitAnswer">Saving…</span>
            </flux:button>
        </div>
    @endif
</div>
