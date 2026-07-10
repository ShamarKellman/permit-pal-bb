<div class="mx-auto max-w-2xl">

    @if ($session)
        {{-- Score hero card --}}
        <div class="rounded-2xl border p-10 text-center mb-8 relative overflow-hidden
            {{ $session->passed ? 'border-go-green/30 bg-go-green/5' : 'border-stop-red/30 bg-stop-red/5' }}">
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: repeating-linear-gradient(45deg, {{ $session->passed ? 'var(--color-go-green)' : 'var(--color-stop-red)' }} 0px, {{ $session->passed ? 'var(--color-go-green)' : 'var(--color-stop-red)' }} 1px, transparent 1px, transparent 16px); background-size: 22px 22px;"></div>
            <div class="relative">
                <div class="font-display text-[5rem] leading-none mb-2
                    {{ $session->passed ? 'text-go-green' : 'text-stop-red' }}">
                    {{ $session->score }}<span class="text-4xl opacity-60">/{{ $session->total_questions }}</span>
                </div>
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold
                    {{ $session->passed
                        ? 'bg-go-green/15 text-go-green border border-go-green/25'
                        : 'bg-stop-red/15 text-stop-red border border-stop-red/25' }}">
                    @if ($session->passed)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Passed
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Not yet — keep studying
                    @endif
                </div>
                <p class="mt-3 text-sm text-zinc-500">Pass mark: 15 / 20 &nbsp;·&nbsp; You scored {{ round(($session->score / $session->total_questions) * 100) }}%</p>
            </div>
        </div>

        {{-- Category breakdown --}}
        <h2 class="font-display text-2xl tracking-wide uppercase mb-4 text-zinc-300">Category Breakdown</h2>
        <div class="space-y-3 mb-8">
            @foreach ($this->categoryBreakdown as $index => $row)
                <div wire:key="{{ $index }}" class="rounded-xl border border-zinc-800 bg-zinc-900/60 p-5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-white text-sm">{{ $row['category'] }}</span>
                        <span class="text-sm font-semibold tabular-nums {{ $row['percentage'] >= 70 ? 'text-go-green' : 'text-stop-red' }}">
                            {{ $row['correct'] }}/{{ $row['total'] }}
                            <span class="text-xs font-normal opacity-70">({{ $row['percentage'] }}%)</span>
                        </span>
                    </div>
                    <div class="h-1.5 w-full rounded-full bg-zinc-800 overflow-hidden">
                        <div class="h-1.5 rounded-full transition-all duration-700 {{ $row['percentage'] >= 70 ? 'bg-go-green' : 'bg-stop-red' }}"
                             style="width: {{ $row['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Question Review --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-display text-2xl tracking-wide uppercase text-zinc-300">Question Review</h2>
                <div class="flex items-center gap-1 rounded-lg border border-zinc-800 bg-zinc-900/60 p-1">
                    @foreach (['all' => 'All', 'correct' => 'Correct', 'incorrect' => 'Incorrect'] as $value => $label)
                        <button
                            wire:click="setFilter('{{ $value }}')"
                            class="px-3 py-1.5 rounded-md text-xs font-semibold transition-colors
                                {{ $filter === $value
                                    ? 'bg-zinc-700 text-white'
                                    : 'text-zinc-500 hover:text-zinc-300' }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($this->questionReview as $index => $row)
                    <div wire:key="review-{{ $index }}"
                         class="rounded-xl border bg-zinc-900/60 p-5 {{ $row['is_correct'] ? 'border-go-green/20' : 'border-stop-red/20' }}">

                        {{-- Question number + text --}}
                        <div class="flex items-start gap-3 mb-3">
                            <span class="shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                                {{ $row['is_correct'] ? 'bg-go-green/15 text-go-green' : 'bg-stop-red/15 text-stop-red' }}">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-sm text-zinc-200 leading-relaxed">{{ $row['question_text'] }}</p>
                        </div>

                        @if ($row['image_path'])
                            <img src="{{ Storage::url($row['image_path']) }}" alt="Road sign for this question" class="ml-9 mb-3 max-h-28 w-auto object-contain">
                        @endif

                        {{-- Answers --}}
                        <div class="ml-9 space-y-2">
                            {{-- User's answer --}}
                            <div class="flex items-center gap-2">
                                @if ($row['is_correct'])
                                    <svg class="w-4 h-4 shrink-0 text-go-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-sm text-go-green font-medium">{{ $row['user_answer'] }}</span>
                                @else
                                    <svg class="w-4 h-4 shrink-0 text-stop-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span class="text-sm text-stop-red font-medium line-through opacity-70">{{ $row['user_answer'] }}</span>
                                @endif
                            </div>

                            {{-- Correct answer (only shown when user was wrong) --}}
                            @if (! $row['is_correct'])
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0 text-go-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-sm text-go-green font-medium">{{ $row['correct_answer'] }}</span>
                                </div>
                            @endif

                            {{-- Explanation --}}
                            @if ($row['explanation'])
                                <p class="text-xs text-zinc-500 leading-relaxed pt-1 border-t border-zinc-800">
                                    {{ $row['explanation'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-zinc-600 text-center py-6">No questions match this filter.</p>
                @endforelse
            </div>
        </div>

        {{-- CTAs --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('test') }}"
               wire:navigate
               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl bg-road-yellow text-zinc-950 font-semibold text-sm hover:bg-road-yellow/90 transition-all hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Try Again
            </a>
            @auth
                <a href="{{ route('study') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl border border-zinc-700 text-zinc-300 font-semibold text-sm hover:border-zinc-500 hover:text-white transition-all hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Study Weak Topics
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl border border-zinc-700 text-zinc-300 font-semibold text-sm hover:border-zinc-500 hover:text-white transition-all hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Create Account to Track Progress
                </a>
            @endauth
        </div>
    @else
        <div class="text-center py-20">
            <div class="font-display text-6xl text-zinc-700 mb-4">No Result</div>
            <p class="text-zinc-500 mb-6">No recent test found.</p>
            <a href="{{ route('test') }}"
               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-road-yellow text-zinc-950 font-semibold text-sm hover:bg-road-yellow/90 transition-all">
                Start a Test
            </a>
        </div>
    @endif
</div>
