<x-layouts::app :title="__('Study Mode')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-display text-3xl tracking-wide uppercase text-white">
                    @if (request()->route('category'))
                        <a href="{{ route('study') }}" wire:navigate class="text-zinc-600 hover:text-zinc-400 transition-colors text-2xl">Study</a>
                        <span class="text-zinc-700 mx-2">/</span>
                        {{ ucfirst(str_replace('-', ' ', request()->route('category'))) }}
                    @else
                        Study Mode
                    @endif
                </h1>
                <p class="text-zinc-500 text-sm mt-1">
                    @if (request()->route('category'))
                        Tap each card to reveal the correct answer.
                    @else
                        Choose a topic to study with flash cards.
                    @endif
                </p>
            </div>
            @if (request()->route('category'))
                <a href="{{ route('study') }}" wire:navigate
                   class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                    All Topics
                </a>
            @endif
        </div>

        @if (request()->route('category'))
            <livewire:study.flash-card :categorySlug="request()->route('category')" />
        @else
            <livewire:study.category-browser />
        @endif
    </div>
</x-layouts::app>
