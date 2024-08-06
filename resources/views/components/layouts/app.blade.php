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

                    <livewire:tenants.user-menu />

                    <x-menu-separator />
                @endif

                <x-menu-item title="Tableaud de board" icon="o-sparkles" link="/" />
                <x-menu-sub title="Gestion Années Scolaires" icon="o-clock">
                    <x-menu-item title="Années Scolaires" icon="o-calendar"
                        link="{{ route('pages:tenants:annees') }}" />
                    <x-menu-item title="Trimestres/Semestres " icon="o-rectangle-stack" link="####" />
                </x-menu-sub>

                <x-menu-sub title="Gestion enseignants" icon="o-users">
                    <x-menu-item title="Enseignants" icon="o-user"
                        link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Attribution Cours/Classes" icon="o-rectangle-stack" link="####" />
                    <x-menu-item title="Présences et Absences" icon="o-calendar" link="####" />
                    <x-menu-item title="Planning et Horaires" icon="o-clock" link="####" />
                    <x-menu-item title="Évaluations " icon="o-presentation-chart-line" link="####" />
                    <x-menu-item title="Gestion des Documents " icon="o-folder-open" link="####" />
                </x-menu-sub>

                <x-menu-sub title="Gestion Sections/Niveaux" icon="o-briefcase">
                    <x-menu-item title="Niveaux" icon="o-rectangle-stack"
                        link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Sections" icon="o-rectangle-stack" link="####" />
                </x-menu-sub>

                <x-menu-sub title="Gestion des Inscriptions" icon="o-briefcase">
                    <x-menu-item title="Niveaux" icon="o-rectangle-stack"
                        link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Sections" icon="o-rectangle-stack" link="####" />
                </x-menu-sub>

                <x-menu-sub title="Gestion Académique" icon="o-academic-cap">
                    <x-menu-item title="Cours et Programmes" icon="o-user"
                        link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Gestion des Évaluations" icon="o-rectangle-stack" link="####" />
                    <x-menu-item title="Absences et Retards" icon="o-calendar" link="####" />
                    <x-menu-item title="Performances Académiques" icon="o-clock" link="####" />
                    <x-menu-item title="Ressources Pédagogiques " icon="o-presentation-chart-line" link="####" />
                    <x-menu-item title="Activités Extrascolaires" icon="o-folder-open" link="####" />
                </x-menu-sub>

                <x-menu-item title="Tableaud de board" icon="o-sparkles" link="###" />
                <x-menu-item title="Tableaud de board" icon="o-sparkles" link="###" />
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

</html>
