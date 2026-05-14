<x-layouts::app :title="__('Study Mode')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <h1 class="text-2xl font-bold">{{ __('Study Mode') }}</h1>
        </div>

        @if (request()->route('category'))
            <livewire:study.flash-card :categorySlug="request()->route('category')" />
        @else
            <livewire:study.category-browser />
        @endif
    </div>
</x-layouts::app>
