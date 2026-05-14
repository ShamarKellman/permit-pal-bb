<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-950 text-white antialiased">
<header class="border-b border-zinc-800 bg-zinc-950/90 backdrop-blur-sm sticky top-0 z-50">
    <div class="mx-auto max-w-4xl px-6 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 group">
            <div class="flex items-center justify-center w-8 h-8 rounded bg-road-yellow">
                <span class="font-display text-zinc-950 text-sm leading-none">BHC</span>
            </div>
            <span class="font-display text-lg tracking-wide text-white">Barbados Highway Code</span>
        </a>

        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="text-sm text-zinc-400 hover:text-white transition-colors">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-sm text-zinc-400 hover:text-white transition-colors">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" wire:navigate
                   class="text-sm text-zinc-400 hover:text-white transition-colors">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" wire:navigate
                       class="text-sm font-medium px-4 py-2 rounded-lg bg-road-yellow text-zinc-950 hover:bg-road-yellow/90 transition-colors">
                        Create Account
                    </a>
                @endif
            @endauth
        </nav>
    </div>
</header>

<main class="py-10 px-6">
    {{ $slot }}
</main>

@persist('toast')
<flux:toast.group>
    <flux:toast />
</flux:toast.group>
@endpersist

@fluxScripts
</body>
</html>
