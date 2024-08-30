<?php

use App\Models\FraisInscription;
use App\Models\Cycle;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    public FraisInscription $fraisInscription;

    #[Rule('required')]
    public ?int $cycle_searchable_id = null;
    #[Rule('required')]
    public string $nom = '';

    #[Rule('required')]
    public string $code = '';

    #[Rule('required')]
    public string $montant = '';

    // Options list
    public Collection $cyclesSearchable;

    public function mount()
    {
        // Fill options when component first renders
        $this->fill($this->fraisInscription);
        $this->search();
        $this->cycle_searchable_id = $this->fraisInscription->cycle_id;
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
        $this->fraisInscription->update($data);
        $this->success('Mise à jour avec succès.', redirectTo: '/frais/inscriptions');
    }

    // delete frais
    public function delete()
    {
        $this->fraisInscription->delete();
        $this->success('Suppression avec succès.', redirectTo: '/frais/inscriptions');
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
    <!-- Grid stuff from Tailwind -->
    <div class="grid gap-5 lg:grid-cols-2">
        <x-card>
            <div>
                <x-form wire:submit="save">
                    <x-choices label="Pour quelle cycle ?" wire:model="cycle_searchable_id" :options="$cyclesSearchable" single
                        searchable />
                    <x-input label="Libelle" wire:model="nom" />
                    <x-input label="Code d'identification" wire:model="code" />
                    <x-input label="Montant" wire:model="montant" suffix="MGA" inline locale="pt-BR" />
                    <x-slot:actions>
                        <x-button label="Annuler" link="/frais/inscriptions" />
                        <x-button label="Mise à jour" icon="o-paper-airplane" spinner="save" type="submit"
                            class="btn-primary" />
                    </x-slot:actions>
                </x-form>
            </div>
        </x-card>
        <div>
            {{-- Get a nice picture from `StorySet` web site --}}
            <img src="https://flow.mary-ui.com/images/edit-form.png" width="300" class="mx-auto" />
        </div>
    </div>

</div>
