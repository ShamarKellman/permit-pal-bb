<div>
    <h2 class="mb-4 text-lg font-semibold">Recent Tests</h2>

    @if ($sessions->isEmpty())
        <p class="text-zinc-500">No tests taken yet. <a href="{{ route('test') }}" class="text-primary underline">Start one!</a></p>
    @else
        <div class="space-y-2">
            @foreach ($sessions as $session)
                <div wire:key="{{ $session->id }}"
                     class="flex items-center justify-between rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex items-center gap-3">
                        <flux:badge :color="$session->passed ? 'green' : 'red'">
                            {{ $session->passed ? 'Pass' : 'Fail' }}
                        </flux:badge>
                        <span class="font-semibold">{{ $session->score }}/{{ $session->total_questions }}</span>
                    </div>
                    <span class="text-sm text-zinc-400">{{ $session->completed_at->diffForHumans() }}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
