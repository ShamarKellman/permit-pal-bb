<div class="mx-auto max-w-2xl">

    @php
        $pct      = $totalQuestions > 0 ? round(($currentIndex / $totalQuestions) * 100) : 0;
        $question = $questions[$currentIndex] ?? null;
    @endphp

    {{-- Header: question counter + progress --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <div>
                <span class="font-display text-road-yellow text-3xl leading-none">{{ $currentIndex + 1 }}</span>
                <span class="text-zinc-600 text-lg font-light"> / {{ $totalQuestions }}</span>
            </div>
            <span class="text-sm font-medium text-zinc-500">{{ $pct }}% complete</span>
        </div>
        <div class="h-1.5 w-full rounded-full bg-zinc-800 overflow-hidden">
            <div class="h-1.5 rounded-full bg-road-yellow transition-all duration-500 ease-out" style="width: {{ $pct }}%"></div>
        </div>
    </div>

    @if ($question)
        {{-- Question card --}}
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-7 shadow-xl mb-6">
            @if ($question->image_path)
                <img src="{{ Storage::url($question->image_path) }}" alt="Question image" class="mb-5 w-full rounded-xl object-cover max-h-52">
            @endif

            <p class="text-lg font-medium text-white leading-relaxed mb-7">{{ $question->question_text }}</p>

            <div class="space-y-3">
                @foreach ($question->answers as $answer)
                    <label wire:key="{{ $answer->id }}"
                           class="flex cursor-pointer items-center gap-4 rounded-xl border p-4 transition-all duration-150
                            {{ $selectedAnswer === $answer->id
                                ? 'border-road-yellow bg-road-yellow/8 text-white'
                                : 'border-zinc-700 bg-zinc-800/50 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800 hover:text-white' }}">
                        <div class="w-5 h-5 rounded-full border-2 shrink-0 flex items-center justify-center transition-all
                            {{ $selectedAnswer === $answer->id ? 'border-road-yellow' : 'border-zinc-600' }}">
                            @if ($selectedAnswer === $answer->id)
                                <div class="w-2.5 h-2.5 rounded-full bg-road-yellow"></div>
                            @endif
                        </div>
                        <input type="radio" wire:model.live="selectedAnswer" value="{{ $answer->id }}" class="sr-only">
                        <span class="text-sm leading-snug">{{ $answer->answer_text }}</span>
                    </label>
                @endforeach
            </div>

            @error('selectedAnswer')
                <p class="mt-4 text-sm text-stop-red flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button
                wire:click="submitAnswer"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-road-yellow text-zinc-950 font-semibold text-sm hover:bg-road-yellow/90 transition-all hover:-translate-y-0.5 disabled:opacity-50 disabled:translate-y-0"
            >
                <span wire:loading.remove wire:target="submitAnswer">
                    {{ $currentIndex + 1 === $totalQuestions ? 'Finish Test' : 'Next Question' }}
                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                </span>
                <span wire:loading wire:target="submitAnswer" class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    Saving…
                </span>
            </button>
        </div>
    @endif
</div>
