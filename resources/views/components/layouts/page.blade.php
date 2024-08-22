@props(['title' => config('app.name')])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 dark:bg-slate-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Cropper.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <livewire:styles />
</head>

<body class="font-sans antialiased">
    {{-- The navbar with `sticky` and `full-width` --}}
    <x-nav sticky full-width>

        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div>{{ config('app.name') }}</div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            <x-button label="Suscription" icon="o-command-line" link="/auth/register" class="btn-ghost btn-sm"
                responsive />
            <x-button label="Se connecter" icon="o-user-circle" link="/auth/login" class="btn-ghost btn-sm"
                responsive />
        </x-slot:actions>
    </x-nav>

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content">
        {{ $slot }}
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <livewire:scripts />
    <script>
        window.addEventListener("DOMContentLoaded", () => Preline.start());
    </script>
</body>
<script>
    document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods.autoInit();
    });
</script>

</html>
