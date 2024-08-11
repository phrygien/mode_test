<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Section;
use App\Models\Niveau;
use Mary\Traits\Toast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
    use Toast;
    use WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public int $niveau_id = 0;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Table headers
    public function headers(): array
    {
        return [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'name', 'label' => 'Libelle', 'class' => 'w-64'], ['key' => 'abreviation', 'label' => 'Abreviation', 'class' => 'w-64'], ['key' => 'niveau.name', 'label' => 'Niveau', 'class' => 'w-64']];
    }

    public function sections(): LengthAwarePaginator
    {
        return Section::query()
            ->with(['niveau'])
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->when($this->niveau_id, fn(Builder $q) => $q->where('niveau_id', $this->niveau_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10); // No more `->get()`
    }

    public function with(): array
    {
        return [
            'sections' => $this->sections(),
            'headers' => $this->headers(),
            'niveaus' => Niveau::all(),
        ];
    }
}; ?>

<div>
    <x-header title="Sections">
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
            <x-button class="btn-primary" label="Creer une section" link="/configurations/sections/create"
                icon="o-plus-circle" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$sections" :sort-by="$sortBy" with-pagination link="sections/{id}/edit" />
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <div class="grid gap-5">
            <x-input placeholder="Nom de la section" wire:model.live.debounce="search" icon="o-magnifying-glass"
                @keydown.enter="$wire.drawer = false" />
            <x-select placeholder="Niveau" wire:model.live="niveau_id" :options="$niveaus" icon="o-flag"
                placeholder-value="0" />
        </div>
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>
