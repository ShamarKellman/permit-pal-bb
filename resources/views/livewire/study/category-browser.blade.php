<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($categories as $category)
        <a wire:key="{{ $category->id }}"
           href="{{ route('study.category', $category->slug) }}"
           class="group flex items-start gap-4 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:border-primary hover:shadow-md dark:border-zinc-700 dark:bg-zinc-900">
            <flux:icon :icon="$category->icon ?? 'book-open'" class="mt-1 size-6 shrink-0 text-primary" />
            <div>
                <p class="font-semibold text-zinc-900 group-hover:text-primary dark:text-white">
                    {{ $category->name }}
                </p>
                {{-- @phpstan-ignore-next-line --}}
                <p class="text-sm text-zinc-500">{{ $category->active_questions_count }} questions</p>
                @if ($category->description)
                    <p class="mt-1 text-xs text-zinc-400">{{ $category->description }}</p>
                @endif
            </div>
        </a>
    @endforeach
</div>
