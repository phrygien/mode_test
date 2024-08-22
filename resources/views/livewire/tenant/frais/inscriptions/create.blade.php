<?php

use App\Models\FraisInscription;
use App\Models\Cycle;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;
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
        $this->search();
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

    // save frais inscription
    public function save()
    {
        $this->validate();
        FraisInscription::create([
            'niveaux_id' => $this->cycle_searchable_id,
            'nom' => $this->nom,
            'code' => $this->code,
            'montant' => $this->montant,
        ]);

        $this->reset();
        $this->success('Fraisn d\'inscriptions créé avec succès.', redirectTo: '/frais/inscriptions');
    }
}; ?>

<div>
    <x-header title="Creation frais" subtitle="Frais pour l'admission" separator />
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
                        <x-button label="Sauvegarder" icon="o-paper-airplane" spinner="save" type="submit"
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
