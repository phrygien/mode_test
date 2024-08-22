<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Section;
use App\Models\FraisInscription;
use Mary\Traits\Toast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
    use Toast;
    use WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public int $section_id = 0;

    public array $sortBy = ['column' => 'nom', 'direction' => 'asc'];

    // Table headers
    public function headers(): array
    {
        return [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'nom', 'label' => 'Libelle', 'class' => 'w-64'], ['key' => 'code', 'label' => 'Code', 'class' => 'w-64'], ['key' => 'montant', 'label' => 'Montant', 'class' => 'w-64'], ['key' => 'cycle.name', 'label' => 'Section', 'class' => 'w-64']];
    }

    public function frais(): LengthAwarePaginator
    {
        return FraisInscription::query()
            ->with(['cycle'])
            ->when($this->search, fn(Builder $q) => $q->where('nom', 'like', "%$this->search%"))
            ->when($this->section_id, fn(Builder $q) => $q->where('niveaux_id', $this->section_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10); // No more `->get()`
    }

    public function with(): array
    {
        return [
            'frais' => $this->frais(),
            'headers' => $this->headers(),
            'sections' => Section::all(),
        ];
    }
}; ?>

<div>
    <x-header title="Frais d'admissions" subtitle="Frais d'admission à l'école">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" link="/frais/inscriptions/create" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table :headers="$headers" :rows="$frais" :sort-by="$sortBy" with-pagination link="sections/{id}/edit" />
    </x-card>
</div>
