<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\AnneeScolaire;
use Mary\Traits\Toast;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
    use Toast;
    // for paginate data
    use WithPagination;
    public string $search = '';
    public bool $drawer = false;

    public array $sortBy = ['column' => 'debut', 'direction' => 'asc'];

    // Table headers
    public function headers(): array
    {
        return [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'debut', 'label' => 'Date debut', 'class' => 'w-64'], ['key' => 'fin', 'label' => 'Date fin', 'class' => 'w-64'], ['key' => 'is_open', 'label' => 'Etat', 'class' => 'w-64'], ['key' => 'name', 'label' => 'Libelle', 'class' => 'w-64']];
    }

    public function annees(): LengthAwarePaginator
    {
        return AnneeScolaire::query()
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5); // No more `->get()`
    }

    // Reset pagination when any component property changes
    public function updated($property): void
    {
        if (!is_array($property) && $property != '') {
            $this->resetPage();
        }
    }

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // close annee scolaire
    public function delete(AnneeScolaire $annee): void
    {
        $annee->update(['is_open' => 0]);
        $this->success("$annee->name is closed", 'Good bye!', position: 'toast-bottom');
    }

    //open annee scolaire
    public function open(AnneeScolaire $annee): void
    {
        // verification si un année scolaire soit ouverte
        $openAnnees = AnneeScolaire::where('is_open', 1)->first();
        if ($openAnnees) {
            $this->error('Une annee scolaire est ouverte', 'Attention!');
            return;
        }
        $annee->update(['is_open' => 1]);
        $this->success("$annee->name sont ouvert", 'Bienvenue!');
    }

    // fermer annee scolaire
    public function close(AnneeScolaire $annee): void
    {
        $annee->update(['is_open' => 0]);
        $this->success("$annee->name sont ferme", 'Good bye!');
    }
    // Add a new property
    public function with(): array
    {
        return [
            'annees' => $this->annees(),
            'headers' => $this->headers(),
        ];
    }
}; ?>

<div>
    <x-header title="Année scolaire">
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
            <x-button label="Créer" link="annees/create" icon="o-plus" class="btn-primary" />
            {{-- <x-theme-toggle class="btn btn-circle btn-ghost" /> --}}
        </x-slot:actions>
    </x-header>
    @empty($annees)
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
                    Pas de donnee
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
        <!-- TABLE  -->
        <x-card>
            <x-table :headers="$headers" :rows="$annees" :sort-by="$sortBy" with-pagination link="annees/{id}/edit">
                @scope('cell_is_open', $annee)
                    @if ($annee->is_open == 1)
                        <span class="badge badge-success">année scolaire ouverte</span>
                    @endif
                    @if ($annee->is_open == 0)
                        <span class="badge badge-warning">année scolaire fermée</span>
                    @endif
                @endscope

                @scope('actions', $annee)
                    @if ($annee->is_open == 1)
                        <x-button icon="o-x-circle" wire:click="close({{ $annee['id'] }})" wire:confirm="Vous etes sure?"
                            spinner class="text-red-500 btn-ghost btn-sm" />
                    @else
                        <x-button icon="o-check-circle" wire:click="open({{ $annee['id'] }})" wire:confirm="Vous etes sure?"
                            spinner class="text-primary-500 btn-ghost btn-sm" />
                    @endif
                @endscope
            </x-table>
        </x-card>
    @endempty

</div>
