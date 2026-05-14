<div>
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-2xl tracking-wide uppercase text-zinc-300">Topics to Improve</h2>
        @if (!$weakCategories->isEmpty())
            <a href="{{ route('study') }}" wire:navigate
               class="text-xs text-primary hover:text-primary/80 transition-colors font-medium flex items-center gap-1">
                Study all
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @endif
    </div>

    @if ($weakCategories->isEmpty())
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/40 p-8 text-center">
            <div class="w-10 h-10 rounded-full bg-go-green/10 border border-go-green/20 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-go-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="font-display text-2xl text-zinc-400 mb-1">All Good!</div>
            <p class="text-zinc-500 text-sm">No weak areas detected. Keep it up!</p>
        </div>
    @else
        <div class="space-y-2">
            @foreach ($weakCategories as $item)
                <a wire:key="{{ $item['category']->id }}"
                   href="{{ route('study.category', $item['category']->slug) }}"
                   wire:navigate
                   class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-900/40 px-5 py-4 transition-all hover:border-stop-red/30 hover:bg-zinc-900 group">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-8 rounded-full bg-stop-red/40 group-hover:bg-stop-red/70 transition-colors"></div>
                        <span class="font-medium text-white text-sm">{{ $item['category']->name }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-sm font-semibold text-stop-red tabular-nums">{{ $item['percentage'] }}%</div>
                            <div class="text-xs text-zinc-600">accuracy</div>
                        </div>
                        <svg class="w-4 h-4 text-zinc-700 group-hover:text-zinc-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
