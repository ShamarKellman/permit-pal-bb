<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-950 text-white antialiased">

    {{-- Road stripe accent --}}
    <div class="fixed inset-x-0 top-0 h-1 bg-road-yellow"></div>

    <div class="flex min-h-screen flex-col items-center justify-center px-6 py-16">

        {{-- Logo --}}
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 mb-10 group">
            <div class="flex items-center justify-center w-10 h-10 rounded bg-road-yellow shrink-0">
                <span class="font-display text-zinc-950 text-base leading-none tracking-wide">BHC</span>
            </div>
            <span class="font-display text-xl tracking-wide text-white">Barbados Highway Code</span>
        </a>

        {{-- Card --}}
        <div class="w-full max-w-sm rounded-xl border border-zinc-800 bg-zinc-900/60 p-8 shadow-2xl">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="mt-8 text-xs text-zinc-600">
            &copy; {{ date('Y') }} Barbados Highway Code. All rights reserved.
        </p>

    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
