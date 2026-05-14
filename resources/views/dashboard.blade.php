<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Welcome header --}}
        <div class="flex items-start justify-between">
            <div>
                <h1 class="font-display text-3xl tracking-wide uppercase text-white">
                    Welcome back, {{ explode(' ', auth()->user()->name)[0] }}
                </h1>
                <p class="text-zinc-500 text-sm mt-1">Track your progress and keep practising.</p>
            </div>
            <a href="{{ route('test') }}"
               wire:navigate
               class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-road-yellow text-zinc-950 font-semibold text-sm hover:bg-road-yellow/90 transition-all hover:-translate-y-0.5 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                New Test
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900/40 p-6">
                <livewire:dashboard.score-history />
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900/40 p-6">
                <livewire:dashboard.weak-topics />
            </div>
        </div>
    </div>
</x-layouts::app>
