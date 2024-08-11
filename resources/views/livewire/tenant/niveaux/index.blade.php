<?php

use App\Models\Niveau;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;

new class extends Component {
    // for paginate data
    use WithPagination;

    public function niveaus()
    {
        return Niveau::all(); // No more `->get()`
    }

    // Add a new property
    public function with(): array
    {
        return [
            'niveaus' => Niveau::withCount('sections')->get(),
        ];
    }
}; ?>

<div>
    <x-header title="Niveau">
        <x-slot:actions>
            <x-button class="btn-primary" label="Creer niveau" link="/configurations/niveaux/create" icon="o-plus-circle" />
        </x-slot:actions>
    </x-header>
    @if (count($niveaus) > 0)
        <!-- Card Section -->
        <div class="mx-auto">
            <!-- Grid -->
            <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 sm:gap-6">
                @foreach ($niveaus as $niveau)
                    <!-- Card -->
                    <a class="flex flex-col transition bg-white border shadow-sm group rounded-xl hover:shadow-md focus:outline-none focus:shadow-md dark:bg-neutral-900 dark:border-neutral-800"
                        href="{{ route('pages:tenants:configurations:niveaux.edit', ['id' => $niveau->id]) }}"
                        wire:navigate>
                        <div class="p-4 md:p-5">
                            <div class="flex items-center justify-between gap-x-3">
                                <div class="grow">
                                    <h3
                                        class="font-semibold text-gray-800 group-hover:text-blue-600 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        {{ $niveau->name }}
                                    </h3>
                                    <p class="text-sm font-semibold text-purple-800 dark:text-amber-500">
                                        {{ $niveau->sections_count }} salles de classe
                                    </p>
                                </div>
                                <div>
                                    <svg class="text-gray-800 shrink-0 size-5 dark:text-neutral-200"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endforeach

            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->
    @else
        <div
            class="flex flex-col bg-white border shadow-sm min-h-60 rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="flex flex-col items-center justify-center flex-auto p-4 md:p-5">
                <svg class="text-gray-500 size-10 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" x2="2" y1="12" y2="12"></line>
                    <path
                        d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                    </path>
                    <line x1="6" x2="6.01" y1="16" y2="16"></line>
                    <line x1="10" x2="10.01" y1="16" y2="16"></line>
                </svg>
                <p class="mt-2 text-sm text-gray-800 dark:text-neutral-300">
                    Pas de niveau pour le moment
                </p>
            </div>
        </div>
    @endif
</div>
