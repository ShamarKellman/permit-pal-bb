<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($categories as $category)
        <a wire:key="{{ $category->id }}"
           href="{{ route('study.category', $category->slug) }}"
           wire:navigate
           class="group flex flex-col gap-4 rounded-2xl border border-zinc-800 bg-zinc-900/50 p-6 transition-all duration-200 hover:border-road-yellow/40 hover:bg-zinc-900 hover:-translate-y-1 hover:shadow-xl hover:shadow-road-yellow/5">
            <div class="flex items-start justify-between">
                <div class="w-10 h-10 rounded-xl bg-road-yellow/10 border border-road-yellow/15 flex items-center justify-center shrink-0">
                    <flux:icon :icon="$category->icon ?? 'book-open'" class="size-5 text-road-yellow" />
                </div>
                <span class="text-xs text-zinc-600 border border-zinc-700 rounded-full px-2.5 py-1 font-medium">
                    {{-- @phpstan-ignore-next-line --}}
                    {{ $category->active_questions_count }} Q
                </span>
            </div>
            <div>
                <p class="font-semibold text-white group-hover:text-road-yellow transition-colors leading-snug">
                    {{ $category->name }}
                </p>
                @if ($category->description)
                    <p class="mt-1 text-xs text-zinc-500 leading-relaxed line-clamp-2">{{ $category->description }}</p>
                @endif
            </div>
            <div class="flex items-center gap-1 text-xs text-zinc-600 group-hover:text-road-yellow/70 transition-colors mt-auto">
                Study this topic
                <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
    @endforeach
</div>
