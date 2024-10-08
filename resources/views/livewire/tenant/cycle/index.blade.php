<?php

use App\Models\Cycle;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;

new class extends Component {
    // for paginate data
    use WithPagination;

    public function cycles()
    {
        return Cycle::all(); // No more `->get()`
    }

    // Add a new property
    public function with(): array
    {
        return [
            'cycles' => $this->cycles(),
        ];
    }
}; ?>

<div>
    <x-header title="Cycles">
        <x-slot:actions>
            <x-button label="Créer" link="cycles/create" icon="o-plus" class="btn-primary" />
            {{-- <x-theme-toggle class="btn btn-circle btn-ghost" /> --}}
        </x-slot:actions>
    </x-header>
    @if (count($cycles) <= 0)
        <div
            class="flex flex-col bg-white border shadow-sm min-h-60 rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="flex flex-col items-center justify-center flex-auto p-4 md:p-5">
                <svg class="text-gray-500 size-10 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" x2="2" y1="12" y2="12"></line>
                    <path
                        d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                    </path>
                    <line x1="6" x2="6.01" y1="16" y2="16"></line>
                    <line x1="10" x2="10.01" y1="16" y2="16"></line>
                </svg>
                <p class="mt-2 text-sm text-gray-800 dark:text-neutral-300">
                    Pas de cycle pour le moment
                </p>
                <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">
                    <a type="button" href="{{ route('pages:tenants:configurations:annees.create') }}" wire:navigate
                        class="inline-flex items-center px-4 py-3 text-sm font-medium text-blue-600 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-blue-500">
                        Créer
                    </a>
                </p>
            </div>
        </div>
    @else
        <!-- Card Section -->
        <div class="mx-auto">
            <!-- Grid -->
            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                @foreach ($cycles as $cycle)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                        href="#">
                        <div class="p-4 md:p-5">
                            <div class="flex justify-between items-center gap-x-3">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        {{ $cycle->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                </div>
                                <div>
                                    <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
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
    @endif

</div>
