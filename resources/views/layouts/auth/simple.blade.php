<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-950 text-white antialiased">

<header class="border-b border-zinc-800 bg-zinc-950/90 backdrop-blur-sm sticky top-0 z-50">
    <div class="mx-auto max-w-4xl px-6 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 group">
            <div class="flex items-center justify-center w-8 h-8 rounded">
                <x-app-logo-icon class="size-5 text-zinc-950" />
            </div>
            <span class="font-display text-lg tracking-wide text-white">Permit Pal</span>
        </a>
    </div>
</header>

<main class="flex items-center justify-center min-h-[calc(100vh-65px)] px-6 py-12">
    <div class="w-full max-w-sm rounded-xl border border-zinc-800 bg-zinc-900/60 p-8 shadow-2xl">
        {{ $slot }}
    </div>
</main>

@persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
@endpersist

@fluxScripts

@include('partials.analytics')
</body>
</html>
