<div>
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-2xl tracking-wide uppercase text-zinc-300">Recent Tests</h2>
        <a href="{{ route('test') }}" wire:navigate
           class="text-xs text-road-yellow hover:text-road-yellow/80 transition-colors font-medium flex items-center gap-1">
            New test
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    @if ($sessions->isEmpty())
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/40 p-8 text-center">
            <div class="font-display text-4xl text-zinc-700 mb-2">No Tests Yet</div>
            <p class="text-zinc-500 text-sm mb-4">Take your first practice test to see your scores here.</p>
            <a href="{{ route('test') }}" wire:navigate
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-road-yellow text-zinc-950 font-semibold text-sm hover:bg-road-yellow/90 transition-all">
                Take a Test
            </a>
        </div>
    @else
        <div class="space-y-2">
            @foreach ($sessions as $session)
                <div wire:key="{{ $session->id }}"
                     class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-900/40 px-5 py-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-bold
                            {{ $session->passed ? 'bg-go-green/10 text-go-green border border-go-green/20' : 'bg-stop-red/10 text-stop-red border border-stop-red/20' }}">
                            {{ $session->passed ? 'P' : 'F' }}
                        </div>
                        <div>
                            <div class="font-semibold text-white tabular-nums">{{ $session->score }}/{{ $session->total_questions }}</div>
                            <div class="text-xs text-zinc-600">{{ round(($session->score / $session->total_questions) * 100) }}%</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-medium {{ $session->passed ? 'text-go-green' : 'text-stop-red' }}">
                            {{ $session->passed ? 'Pass' : 'Fail' }}
                        </div>
                        <div class="text-xs text-zinc-600">{{ $session->completed_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
