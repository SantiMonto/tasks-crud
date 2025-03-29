<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-white dark:border-zinc-900 shadow-lg">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="flex items-center justify-center py-4">
                <h3 class="text-lg font-semibold text-amber-50 dark:text-amber-50 bg-accent px-4 py-2 rounded-xl">
                    Crud de Tareas
                </h3>
            </a>

            <flux:navlist variant="outline" class="px-3">
                <flux:navlist.group :heading="__('Menú Principal')">
                    <flux:navlist.item icon="clipboard" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Tareas') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:dropdown position="bottom" align="start">
                <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()" icon-trailing="chevrons-up-down" />
                <flux:menu class="w-[220px]">
                    <div class="p-3 text-sm">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-10 w-10 rounded-lg bg-neutral-300 dark:bg-neutral-700 text-black dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                            <div>
                                <span class="block font-semibold">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                    <flux:menu.separator />
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Configuración') }}
                    </flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Cerrar sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />
                <flux:menu>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Configuración') }}
                    </flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Cerrar sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>