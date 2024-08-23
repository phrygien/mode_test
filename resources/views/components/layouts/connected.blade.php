<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="luxury">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @filepondScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        {{-- <x-slot:brand>
            <x-app-brand />
        </x-slot:brand> --}}
        <x-slot:actions>
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            {{-- <x-app-brand class="p-5 pt-3" /> --}}

            {{-- MENU --}}
            <x-menu title="{{ null }}" activate-by-route>

                @if (auth()->check())
                    {{-- <x-menu-separator /> --}}

                    <livewire:tenants.user-menu />
                    {{-- <x-menu-item title="Theme" icon="o-swatch" @click="$dispatch('mary-toggle-theme')" /> --}}
                    <x-menu-separator />
                @endif

                @if (!auth()->user()->tenant)
                    <x-menu-item title="Finaliser votre setup" icon="o-adjustments-horizontal" link="/setup" />
                @else
                    <x-menu-item title="Accueil" icon="o-home" link="/accueil" />
                    <x-menu-item title="Mon abonnement" icon="o-command-line" link="/my-setup" />
                    {{-- <x-menu-sub title="Product catalogue" icon="o-cube">
                        <x-menu-item title="Modules" icon="o-cube"
                            link="{{ route('pages:tenants:settings:profile') }}" />
                        <x-menu-item title="Plan" icon="o-cube" link="{{ route('pages:admin:plan') }}" />
                    </x-menu-sub> --}}
                @endif
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>
<script>
    document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods.autoInit();
    });
</script>

</html>
