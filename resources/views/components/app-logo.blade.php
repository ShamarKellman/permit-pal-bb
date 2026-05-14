@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Barbados Highway Code" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-road-yellow">
            <span class="font-display text-zinc-950 text-xs leading-none tracking-wide">BHC</span>
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Barbados Highway Code" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-road-yellow">
            <span class="font-display text-zinc-950 text-xs leading-none tracking-wide">BHC</span>
        </x-slot>
    </flux:brand>
@endif
