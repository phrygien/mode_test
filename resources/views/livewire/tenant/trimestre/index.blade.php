<?php
use Livewire\WithPagination;
use App\Models\AnneeScolaire;
use App\Models\Trimestre;
use Mary\Traits\Toast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;
    use WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public int $annee_scolaire_id = 0;

    public array $sortBy = ['column' => 'debut', 'direction' => 'asc'];

    // Table headers
    public function headers(): array
    {
        return [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'debut', 'label' => 'Date debut', 'class' => 'w-64'], ['key' => 'fin', 'label' => 'Date fin', 'class' => 'w-64'], ['key' => 'anneescolaire.name', 'label' => 'Annee scolaire', 'class' => 'w-64']];
    }

    public function trimestres(): LengthAwarePaginator
    {
        return Trimestre::query()
            ->with(['anneescolaire'])
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->when($this->annee_scolaire_id, fn(Builder $q) => $q->where('annee_scolaire_id', $this->niveau_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10); // No more `->get()`
    }

    public function with(): array
    {
        return [
            'trimestres' => $this->trimestres(),
            'headers' => $this->headers(),
            'anneescolaires' => AnneeScolaire::all(),
        ];
    }
}; ?>

<div>
    <x-header title="Trimestres" subtitle="Gestion des trimestres">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table :headers="$headers" :rows="$trimestres" :sort-by="$sortBy" with-pagination link="sections/{id}/edit" />
    </x-card>
</div>
