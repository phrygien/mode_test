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

    // save frais admission
    public function save()
    {
        $this->validate();
        try {
            // get current annee scolaire open
            $annee_open = AnneeScolaire::where('is_open', true)->first();
            if ($annee_open != null) {
                // create frais
                FraisAdmission::create([
                    'cycle_id' => $this->cycle_searchable_id,
                    'libelle' => $this->libelle,
                    'annee_scolaire_id' => $annee_open->id,
                    'user_id' => Auth::user()->id,
                    'montant' => $this->montant,
                ]);

                $this->success('Frais d\'admission créé avec succès.', redirectTo: '/frais/admissions');
                $this->reset();
            } else {
                $this->warning('No Open Data Found !');
                return;
            }
        } catch (\Exception $e) {
            dd($e);
            $this->error('Internal error !');
        }
    }
}; ?>

<div>
    <x-header title="Creation frais d'admission" separator />
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
