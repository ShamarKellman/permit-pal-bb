<div>
    <h2 class="mb-4 text-lg font-semibold">Topics to Study</h2>

    @if ($weakCategories->isEmpty())
        <p class="text-zinc-500">No weak areas detected. Keep it up!</p>
    @else
        <div class="space-y-3">
            @foreach ($weakCategories as $item)
                <a wire:key="{{ $item['category']->id }}"
                   href="{{ route('study.category', $item['category']->slug) }}"
                   class="flex items-center justify-between rounded-xl border border-zinc-200 p-4 transition hover:border-stop-red/50 dark:border-zinc-700">
                    <span class="font-medium">{{ $item['category']->name }}</span>
                    <flux:badge color="red">{{ $item['percentage'] }}%</flux:badge>
                </a>
            @endforeach
        </div>
    @endif
</div>
