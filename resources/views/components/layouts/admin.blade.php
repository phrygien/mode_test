<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="p-5 pt-3" />

            {{-- MENU --}}
            <x-menu title="{{ null }}" activate-by-route>

                @if (auth()->check())
                    <x-menu-separator />

                    <livewire:admins.user-menu />

                    <x-menu-separator />
                @endif

                <x-menu-item title="Tableau de bord" icon="o-sparkles" link="/admin/dashboard" />
                <x-menu-item title="Fonctionalités" icon="o-cog-6-tooth" link="###" />
                <x-menu-item title="Produits & catalogue" icon="o-cube-transparent" link="###" />
                <x-menu-item title="Subscriptions" icon="o-clock" link="/admin/subscriptions" />
                {{-- <x-menu-sub title="Produits & catalogue" icon="o-cog-6-tooth">
                    <x-menu-item title="Profile" icon="o-wifi" link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Tenant" icon="o-archive-box" link="####" />
                </x-menu-sub> --}}
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
    window.addEventListener("DOMContentLoaded", () => Preline.start());
</script>
<script>
    document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods.autoInit();
    });
</script>

</html>
