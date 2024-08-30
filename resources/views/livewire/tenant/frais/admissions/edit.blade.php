<?php

use App\Models\FraisAdmission;
use App\Models\Cycle;
use App\Models\AnneeScolaire;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    public FraisAdmission $fraisAdmission;

    #[Rule('required')]
    public ?int $cycle_searchable_id = null;

    // Options list
    public Collection $cyclesSearchable;

    #[Rule('required')]
    public string $libelle = '';

    #[Rule('required')]
    public string $montant = '';

    public function mount()
    {
        // Fill options when component first renders
        $this->fill($this->fraisAdmission);
        $this->search();
        $this->cycle_searchable_id = $this->fraisAdmission->cycle_id;
    }

    // Also called as you type
    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Cycle::where('id', $this->cycle_searchable_id)->get();

        $this->cyclesSearchable = Cycle::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    // update frais
    public function save()
    {
        $data = $this->validate();
        $this->fraisAdmission->update($data);
        $this->success('Mise à jour avec succès.', redirectTo: '/frais/admissions');
    }

    // delete frais
    public function delete()
    {
        $this->fraisAdmission->delete();
        $this->success('Suppression avec succès.', redirectTo: '/frais/admissions');
    }

    public function with(): array
    {
        return [
            'cyclesSearchable' => Cycle::all(), // Available cycle
        ];
    }
}; ?>

<div>
    <x-header title="Mise à jour frais" separator>
        <x-slot:actions>
            <x-button class="btn-error" label="Supprimer" icon="o-trash" wire:confirm="Vous etes sure?"
                wire:click="delete()" />
        </x-slot:actions>
    </x-header>
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <x-form wire:submit="save">
                <x-choices label="Pour quelle cycle ?" wire:model="cycle_searchable_id" :options="$cyclesSearchable" single
                    searchable />
                <x-input label="Libelle" wire:model="libelle" />
                <x-input label="Montant" wire:model="montant" suffix="MGA" inline locale="pt-BR" />
                <x-slot:actions>
                    <x-button label="Annuler" link="/frais/admissions" />
                    <x-button label="Sauvegarder" icon="o-paper-airplane" spinner="save" type="submit"
                        class="btn-primary" />
                </x-slot:actions>
            </x-form>
        </div>
        <div>
            {{-- Get a nice picture from `StorySet` web site --}}
            <img src="https://flow.mary-ui.com/images/edit-form.png" width="300" class="mx-auto" />
        </div>
    </div>
</div>
