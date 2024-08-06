@props(['title' => config('app.name')])

<x-layouts.page-admin title="{{ $title }}">
    <div class="flex flex-col items-center justify-center flex-1 min-h-full px-6 py-12 mt-5 lg:px-8">
        {{ $slot }}
    </div>
</x-layouts.page-admin>
