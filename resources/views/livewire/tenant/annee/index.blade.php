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
</div>
