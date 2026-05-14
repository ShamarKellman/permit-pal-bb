<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <livewire:dashboard.score-history />
            <livewire:dashboard.weak-topics />
        </div>
    </div>
</x-layouts::app>
