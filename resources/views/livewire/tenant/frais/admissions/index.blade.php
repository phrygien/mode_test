<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use App\Models\FraisAdmission;
use App\Models\Cycle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
new class extends Component {
    use Toast;
    use WithPagination;
    public string $search = '';
    public bool $drawer = false;
    public int $cycle_id = 0;
    public array $sortBy = ['column' => 'libelle', 'direction' => 'asc'];

    // Table headers
    public function headers(): array
    {
        return [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'libelle', 'label' => 'Libelle', 'class' => 'w-64'], ['key' => 'anneescolaire.name', 'label' => 'Anneescolaire', 'class' => 'w-64'], ['key' => 'montant', 'label' => 'Montant', 'class' => 'w-64'], ['key' => 'cycle.name', 'label' => 'Cycle', 'class' => 'w-64']];
    }

    // get frais d'admission
    public function frais(): LengthAwarePaginator
    {
        return FraisAdmission::query()
            ->with(['cycle', 'anneescolaire'])
            ->when($this->search, fn(Builder $q) => $q->where('libelle', 'like', "%$this->search%"))
            ->when($this->cycle_id, fn(Builder $q) => $q->where('cycle_id', $this->cycle_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10); // No more `->get()`
    }

    public function with(): array
    {
        return [
            'frais' => $this->frais(),
            'headers' => $this->headers(),
            'cycles' => Cycle::all(),
        ];
    }
}; ?>

<div>
    <x-header title="Frais d'admission" separator>
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" link="/frais/admissions/create" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table :headers="$headers" :rows="$frais" :sort-by="$sortBy" with-pagination
            link="/frais/admissions/{id}/edit" />
    </x-card>
</div>
