<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @filepondScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Cropper.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />

    {{-- Vanilla Calendar --}}
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.css" rel="stylesheet">

    {{-- Flatpickr  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/YOUR-KEY-HERE/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    {{-- EasyMDE --}}
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

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

                    <x-menu-separator />
                @endif

                <x-menu-item title="Tableaud de board" icon="o-sparkles" link="/" />
                <x-menu-sub title="Gestion des établissemnts" icon="o-cog-8-tooth">
                    <x-menu-item title="Années scolaires" icon="o-clock"
                        link="{{ route('pages:tenants:configurations:annees') }}" />
                    <x-menu-item title="Cyles d'etudes" icon="o-presentation-chart-line"
                        link="/configurations/cycles" />
                    <x-menu-item title="Classes" icon="o-beaker" link="/configurations/niveaux" />
                    <x-menu-item title="Sections" icon="o-rectangle-stack" link="/configurations/sections" />
                    <x-menu-item title="Salles de classe" icon="o-home-modern" link="###" />
                    <x-menu-item title="Trimestres " icon="o-calendar-days" link="/configurations/trimestres" />
                    <x-menu-item title="Frais d'admissions" icon="o-banknotes" link="/frais/admissions" />
                    <x-menu-item title="Frais d'inscriptions" icon="o-banknotes" link="/frais/inscriptions" />
                    <x-menu-item title="Frais scolaires" icon="o-currency-euro" link="####" />
                </x-menu-sub>
                {{-- <x-menu-sub title="Niveaux d'etudes" icon="o-academic-cap">
                    <x-menu-item title="Frais d'adminissions" icon="o-banknotes" link="/frais/inscriptions" />
                    <x-menu-item title="Frais scolaires" icon="o-currency-euro" link="####" />
                </x-menu-sub> --}}

                {{-- <x-menu-sub title="Gestion de frais" icon="o-currency-dollar">
                    <x-menu-item title="Frais d'adminissions" icon="o-banknotes" link="/frais/inscriptions" />
                    <x-menu-item title="Frais scolaires" icon="o-currency-euro" link="####" />
                </x-menu-sub> --}}
                <x-menu-item title="Admissions" icon="o-presentation-chart-line" link="/academy/admissions" />
                {{-- <x-menu-sub title="Gestion des admissions" icon="o-archive-box-arrow-down">
                    <x-menu-item title="Demande d'admission " icon="o-clipboard-document-list"
                        link="/academy/admissions/create" />
                    <x-menu-item title="Admissions" icon="o-presentation-chart-line" link="/academy/admissions" />
                </x-menu-sub> --}}

                <x-menu-item title="Gestion des élèves" icon="o-user-group" link="###" />
                <x-menu-item title="Novelles inscriptions" icon="o-folder-open" link="###" />

                <x-menu-sub title="Suivi paiements" icon="o-banknotes">
                    <x-menu-item title="Paiement admissions" icon="o-banknotes" link="###" />
                    <x-menu-item title="Paiement inscriptions" icon="o-banknotes" link="####" />
                    <x-menu-item title="Paiement frais" icon="o-banknotes" link="####" />
                </x-menu-sub>

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
    {{-- <script>
        window.addEventListener("DOMContentLoaded", () => Preline.start());
    </script> --}}
</body>
{{-- <script>
    document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods.autoInit();
    });
</script> --}}

</html>
