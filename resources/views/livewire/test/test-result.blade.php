<div class="mx-auto max-w-2xl">
    <h1 class="mb-8 text-2xl font-bold">Test Result</h1>

    @if ($session)
        <div class="mb-8 rounded-2xl border p-8 text-center
            {{ $session->passed ? 'border-go-green bg-go-green/10' : 'border-stop-red bg-stop-red/10' }}">
            <p class="text-5xl font-bold {{ $session->passed ? 'text-go-green' : 'text-stop-red' }}">
                {{ $session->score }}/{{ $session->total_questions }}
            </p>
            <p class="mt-2 text-xl font-semibold">
                {{ $session->passed ? 'Pass' : 'Not yet — keep studying' }}
            </p>
            <p class="mt-1 text-sm text-zinc-500">Pass mark: 15/20</p>
        </div>

        <h2 class="mb-4 text-lg font-semibold">Category Breakdown</h2>
        <div class="space-y-3">
            @foreach ($this->categoryBreakdown as $index => $row)
                <div wire:key="{{ $index }}" class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="font-medium">{{ $row['category'] }}</span>
                        <span class="{{ $row['percentage'] >= 70 ? 'text-go-green' : 'text-stop-red' }}">
                            {{ $row['correct'] }}/{{ $row['total'] }} ({{ $row['percentage'] }}%)
                        </span>
                    </div>
                    <div class="h-2 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800">
                        <div class="h-2 rounded-full {{ $row['percentage'] >= 70 ? 'bg-go-green' : 'bg-stop-red' }}"
                             style="width: {{ $row['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex gap-3">
            <flux:button href="{{ route('test') }}" variant="primary" wire:navigate>Try Again</flux:button>
            <flux:button href="{{ route('study') }}" wire:navigate>Study Weak Topics</flux:button>
        </div>
    @else
        <p class="text-center text-zinc-500">
            No recent test found.
            <a href="{{ route('test') }}" class="text-primary underline">Start a test</a>.
        </p>
    @endif
</div>
