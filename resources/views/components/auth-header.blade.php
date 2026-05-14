@props([
    'title',
    'description',
])

<div class="flex w-full flex-col gap-1 text-center mb-2">
    <h1 class="font-display text-3xl tracking-wide text-white">{{ $title }}</h1>
    <p class="text-sm text-zinc-400">{{ $description }}</p>
</div>
