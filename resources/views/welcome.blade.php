<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-950 text-white antialiased overflow-x-hidden">

        {{-- NAV --}}
        <header class="fixed top-0 left-0 right-0 z-50 border-b border-zinc-800/60 bg-zinc-950/80 backdrop-blur-md">
            <div class="mx-auto max-w-6xl px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-road-yellow">
                        <x-app-logo-icon class="size-6 text-zinc-950" />
                    </div>
                    <span class="font-display text-xl tracking-wide hidden sm:block">Permit Pal</span>
                </div>
                <nav class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-zinc-400 hover:text-white transition-colors px-3 py-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-zinc-400 hover:text-white transition-colors px-3 py-2">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium px-4 py-2 rounded-lg bg-road-yellow text-zinc-950 hover:bg-road-yellow/90 transition-colors">Sign up free</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        {{-- HERO --}}
        <section class="relative min-h-screen flex flex-col items-center justify-center pt-20 pb-16 px-6">
            <div class="hero-glow absolute inset-0 pointer-events-none"></div>
            <div class="absolute left-1/2 top-0 w-1.5 h-full -translate-x-1/2 road-dash opacity-[0.06] pointer-events-none"></div>

            <div class="relative text-center max-w-5xl mx-auto">
                <div class="fade-up fade-up-1 inline-flex items-center gap-2 px-4 py-2 rounded-full border border-road-yellow/25 bg-road-yellow/8 text-road-yellow text-sm font-medium mb-8">
                    <span class="w-2 h-2 rounded-full bg-road-yellow animate-pulse inline-block"></span>
                    Unofficial Barbados Permit Test Preparation
                </div>

                <h1 class="fade-up fade-up-2 font-display text-[clamp(3.5rem,10vw,8rem)] leading-[0.92] tracking-wide uppercase mb-6">
                    Pass Your<br>
                    <span class="text-road-yellow">Highway</span><br>
                    Code Test
                </h1>

                <p class="fade-up fade-up-3 text-lg md:text-xl text-zinc-400 max-w-xl mx-auto mb-10 leading-relaxed">
                    Practice with real questions, identify weak areas, and build confidence to pass first time. No account needed to start.
                </p>

                <div class="fade-up fade-up-4 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('test') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-road-yellow text-zinc-950 font-semibold text-base hover:bg-road-yellow/90 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-road-yellow/20">
                        Take a Free Test
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-xl border border-zinc-700 text-zinc-300 font-semibold text-base hover:border-zinc-500 hover:text-white transition-all hover:-translate-y-0.5">
                            Create Free Account
                        </a>
                    @endif
                </div>
            </div>

            <div class="fade-up fade-up-5 relative mt-20 grid grid-cols-3 gap-8 md:gap-16 text-center max-w-2xl mx-auto">
                <div>
                    <div class="font-display text-5xl md:text-6xl text-road-yellow leading-none mb-1">20</div>
                    <div class="text-xs text-zinc-500 uppercase tracking-wider">Questions per test</div>
                </div>
                <div class="border-x border-zinc-800 px-4 md:px-8">
                    <div class="font-display text-5xl md:text-6xl text-road-yellow leading-none mb-1">75%</div>
                    <div class="text-xs text-zinc-500 uppercase tracking-wider">Pass mark</div>
                </div>
                <div>
                    <div class="font-display text-5xl md:text-6xl text-road-yellow leading-none mb-1">Free</div>
                    <div class="text-xs text-zinc-500 uppercase tracking-wider">No cost, ever</div>
                </div>
            </div>

            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce text-zinc-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </section>

        {{-- HOW IT WORKS --}}
        <section class="py-24 px-6 border-t border-zinc-900">
            <div class="mx-auto max-w-6xl">
                <div class="text-center mb-16">
                    <p class="font-display text-road-yellow text-sm tracking-widest uppercase mb-3">How it works</p>
                    <h2 class="font-display text-5xl md:text-6xl tracking-wide uppercase leading-tight">Everything You Need<br>to Pass</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="card-hover group rounded-2xl border border-zinc-800 bg-zinc-900/40 p-8">
                        <div class="w-12 h-12 rounded-xl bg-road-yellow/10 border border-road-yellow/20 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-road-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <h3 class="font-display text-2xl tracking-wide uppercase mb-3 group-hover:text-road-yellow transition-colors">Practice Tests</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed mb-6">20 randomised questions drawn from real Highway Code topics. Instant results with a category breakdown.</p>
                        <a href="{{ route('test') }}" class="inline-flex items-center gap-1.5 text-sm text-road-yellow font-medium group-hover:gap-2.5 transition-all">
                            Take a test <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <div class="card-hover group rounded-2xl border border-zinc-800 bg-zinc-900/40 p-8">
                        <div class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="font-display text-2xl tracking-wide uppercase mb-3 group-hover:text-primary transition-colors">Study Mode</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed mb-6">Flash cards by topic. Tap to flip and reveal the correct answer with a full explanation.</p>
                        @auth
                            <a href="{{ route('study') }}" class="inline-flex items-center gap-1.5 text-sm text-primary font-medium group-hover:gap-2.5 transition-all">Start studying <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm text-primary font-medium group-hover:gap-2.5 transition-all">Create account <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                        @endauth
                    </div>

                    <div class="card-hover group rounded-2xl border border-zinc-800 bg-zinc-900/40 p-8">
                        <div class="w-12 h-12 rounded-xl bg-go-green/10 border border-go-green/20 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-go-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="font-display text-2xl tracking-wide uppercase mb-3 group-hover:text-go-green transition-colors">Track Progress</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed mb-6">Score history and weak-topic detection so you know exactly where to focus your revision.</p>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-go-green font-medium group-hover:gap-2.5 transition-all">View dashboard <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm text-go-green font-medium group-hover:gap-2.5 transition-all">Sign up free <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA BANNER --}}
        <section class="py-24 px-6">
            <div class="mx-auto max-w-4xl">
                <div class="relative overflow-hidden rounded-3xl border border-road-yellow/20 bg-gradient-to-br from-zinc-900 to-zinc-950 px-8 md:px-16 py-16 text-center">
                    <div class="absolute inset-0 opacity-[0.04]" style="background-image: repeating-linear-gradient(45deg, var(--color-road-yellow) 0px, var(--color-road-yellow) 1px, transparent 1px, transparent 20px); background-size: 28px 28px;"></div>
                    <div class="relative">
                        <h2 class="font-display text-5xl md:text-7xl tracking-wide uppercase mb-4">Ready to Pass?</h2>
                        <p class="text-zinc-400 mb-8 text-lg">No sign-up required. Start right now.</p>
                        <a href="{{ route('test') }}" class="inline-flex items-center gap-2 px-10 py-4 rounded-xl bg-road-yellow text-zinc-950 font-semibold text-lg hover:bg-road-yellow/90 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-road-yellow/20">
                            Start Test Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="border-t border-zinc-900 py-8 px-6 text-center space-y-2">
            <p class="text-zinc-600 text-sm">Permit Pal — Barbados Permit Test Preparation</p>
            <p class="text-zinc-700 text-xs max-w-lg mx-auto">This website is not a replacement for purchasing the official Highway Code from the Barbados Licensing Authority (BLA). It is a study aid only.</p>
        </footer>

        @fluxScripts
    </body>
</html>
