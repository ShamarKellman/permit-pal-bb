<div class="mx-auto max-w-2xl">
    @if ($this->currentQuestion)
        <div class="mb-4 flex items-center justify-between text-sm text-zinc-500">
            <span>{{ $currentIndex + 1 }} / {{ $questions->count() }}</span>
            <flux:badge>{{ $this->currentQuestion->difficulty }}</flux:badge>
        </div>

        {{-- Alpine flip card — click triggers wire:flip, animation is purely CSS --}}
        <div
            x-data="{ flipped: @entangle('isFlipped') }"
            x-on:click="$wire.flip()"
            class="relative h-64 cursor-pointer"
            style="perspective: 1000px"
        >
            <div
                class="relative size-full transition-transform duration-500"
                style="transform-style: preserve-3d"
                :style="flipped ? 'transform: rotateY(180deg)' : ''"
            >
                {{-- Front --}}
                <div class="absolute inset-0 flex items-center justify-center rounded-2xl border border-zinc-200 bg-white p-6 text-center shadow-md dark:border-zinc-700 dark:bg-zinc-900"
                     style="backface-visibility: hidden">
                    <p class="text-lg font-medium text-zinc-900 dark:text-white">
                        {{ $this->currentQuestion->question_text }}
                    </p>
                </div>

                {{-- Back --}}
                <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 rounded-2xl border border-primary bg-primary/5 p-6 text-center shadow-md"
                     style="backface-visibility: hidden; transform: rotateY(180deg)">
                    @php $correct = $this->currentQuestion->answers->firstWhere('is_correct', true); @endphp
                    @if ($correct)
                        <p class="font-semibold text-primary">{{ $correct->answer_text }}</p>
                        @if ($correct->explanation)
                            <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $correct->explanation }}</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <p class="mt-2 text-center text-xs text-zinc-400">Tap card to reveal answer</p>

        <div class="mt-6 flex justify-between">
            <flux:button wire:click="previous" :disabled="$currentIndex === 0" icon="arrow-left">Previous</flux:button>
            <flux:button wire:click="next" :disabled="$currentIndex === $questions->count() - 1" icon-trailing="arrow-right">Next</flux:button>
        </div>
    @else
        <p class="text-center text-zinc-500">No questions available for this category.</p>
    @endif
</div>
