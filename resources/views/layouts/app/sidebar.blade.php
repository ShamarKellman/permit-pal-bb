<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-950 antialiased">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-800 bg-zinc-950">
            <flux:sidebar.header class="border-b border-zinc-800 pb-4">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-1 py-1">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg shrink-0">
                        <x-app-logo-icon class="size-5 text-zinc-950" />
                    </div>
                    <div>
                        <div class="font-display text-base tracking-wide text-white leading-none">Permit</div>
                        <div class="font-display text-xs tracking-wide text-zinc-500 leading-none mt-0.5">Pal</div>
                    </div>
                </a>
                <flux:sidebar.collapse class="lg:hidden ml-auto" />
            </flux:sidebar.header>

            <flux:sidebar.nav class="mt-4">
                <flux:sidebar.group :heading="__('Navigation')" class="grid">
                    <flux:sidebar.item
                        icon="home"
                        :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')"
                        wire:navigate
                    >{{ __('Dashboard') }}</flux:sidebar.item>

                    <flux:sidebar.item
                        :href="route('study')"
                        :current="request()->routeIs('study*')"
                        icon="book-open"
                        wire:navigate
                    >{{ __('Study') }}</flux:sidebar.item>

                    <flux:sidebar.item
                        :href="route('test')"
                        :current="request()->routeIs('test*')"
                        icon="clipboard-document-list"
                        wire:navigate
                    >{{ __('Practice Test') }}</flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block border-t border-zinc-800 pt-4" :name="auth()->user()->name" />
        </flux:sidebar>

        {{-- Mobile header --}}
        <flux:header class="lg:hidden border-b border-zinc-800 bg-zinc-950">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <div class="flex items-center gap-2 mx-auto">
                <div class="flex items-center justify-center w-7 h-7 rounded-md">
                    <x-app-logo-icon class="size-4 text-zinc-950" />
                </div>
                <span class="font-display text-sm tracking-wide text-white">Permit Pal</span>
            </div>

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer" data-test="logout-button">
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
