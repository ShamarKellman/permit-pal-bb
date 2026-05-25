<div class="mx-auto max-w-2xl">
    @if ($this->currentQuestion)
        {{-- Progress --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="font-display text-road-yellow text-3xl leading-none">{{ $currentIndex + 1 }}</span>
                <span class="text-zinc-600 text-lg font-light"> / {{ $questions->count() }}</span>
            </div>
            <flux:badge>{{ $this->currentQuestion->difficulty }}</flux:badge>
        </div>

        <div class="mb-2 h-1 w-full rounded-full bg-zinc-800 overflow-hidden">
            <div class="h-1 rounded-full bg-road-yellow/50 transition-all duration-300"
                 style="width: {{ $questions->count() > 0 ? round((($currentIndex + 1) / $questions->count()) * 100) : 0 }}%">
            </div>
        </div>

        {{-- Flip card --}}
        <div
            x-data="{ flipped: @entangle('isFlipped') }"
            x-on:click="$wire.flip()"
            class="relative mt-6 h-72 cursor-pointer select-none"
            style="perspective: 1200px; -webkit-perspective: 1200px"
        >
            <div
                class="relative size-full transition-transform duration-500"
                style="transform-style: preserve-3d; -webkit-transform-style: preserve-3d"
                :style="flipped ? 'transform: rotateY(180deg); -webkit-transform: rotateY(180deg)' : ''"
            >
                {{-- Front --}}
                <div class="absolute inset-0 flex flex-col items-center justify-center rounded-2xl border border-zinc-700 bg-zinc-900 p-8 text-center shadow-xl"
                     style="backface-visibility: hidden; -webkit-backface-visibility: hidden">
                    <div class="w-8 h-8 rounded-lg bg-road-yellow/10 border border-road-yellow/20 flex items-center justify-center mb-4">
                        <svg class="w-4 h-4 text-road-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-base font-medium text-white leading-relaxed">
                        {{ $this->currentQuestion->question_text }}
                    </p>
                </div>

                {{-- Back --}}
                <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 rounded-2xl border border-road-yellow/30 bg-zinc-900 p-8 text-center shadow-xl"
                     style="backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(180deg); -webkit-transform: rotateY(180deg)">
                    @php $correct = $this->currentQuestion->answers->firstWhere('is_correct', true); @endphp
                    @if ($correct)
                        <div class="w-8 h-8 rounded-lg bg-go-green/10 border border-go-green/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-go-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="font-semibold text-white text-base">{{ $correct->answer_text }}</p>
                        @if ($correct->explanation)
                            <p class="text-sm text-zinc-400 leading-relaxed max-w-sm">{{ $correct->explanation }}</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <p class="mt-3 text-center text-xs text-zinc-600">Tap card to reveal answer</p>

        {{-- Navigation --}}
        <div class="mt-6 flex items-center justify-between">
            <flux:button wire:click="previous" :disabled="$currentIndex === 0" icon="arrow-left" variant="ghost">
                Previous
            </flux:button>
            <span class="text-xs text-zinc-700">{{ $currentIndex + 1 }} of {{ $questions->count() }}</span>
            <flux:button wire:click="next" :disabled="$currentIndex === $questions->count() - 1" icon-trailing="arrow-right" variant="ghost">
                Next
            </flux:button>
        </div>

        <livewire:report-concern
            :question-id="$this->currentQuestion->id"
            :wire:key="'report-' . $this->currentQuestion->id"
        />

    @else
        <div class="text-center py-20">
            <div class="font-display text-4xl text-zinc-700 mb-3">No Questions</div>
            <p class="text-zinc-500 text-sm">No questions available for this category.</p>
        </div>
    @endif
</div>
