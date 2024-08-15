<?php

use App\Models\Trimestre;
use App\Models\AnneeScolaire;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public string $nom = '';

    #[Rule('required')]
    public string $debut = '';

    #[Rule('required')]
    public string $fin = '';

    // create trimestre
    public function save()
    {
        $this->validate();
        // get open annee scolaire
        $anneeopen = AnneeScolaire::where('is_open', true)->first();
        //save trimestre
        Trimestre::create([
            'nom' => $this->nom,
            'debut' => $this->debut,
            'fin' => $this->fin,
            'annee_scolaire_id' => $anneeopen->id,
        ]);
        $this->success('Trimestre avec succès.', redirectTo: '/configurations/trimestres');
    }
}; ?>

<div>
    <div>
        <x-header title="Créer trimestre" separator>
            <x-slot:actions>
                <x-theme-toggle class="btn btn-circle btn-ghost" />
            </x-slot:actions>
        </x-header>

        <!-- Grid stuff from Tailwind -->
        <div class="grid gap-5 lg:grid-cols-2">
            <x-card>
                <div>
                    <x-form wire:submit="save">
                        <x-input wire:model="nom" label="Libelle trimestre" />
                        <x-datetime label="Debut" wire:model="debut" icon="o-calendar" />
                        <x-datetime label="Fin" wire:model="fin" icon="o-calendar" />
                        <x-slot:actions>
                            <x-button label="Annuler" link="/configurations/trimestres" />
                            <x-button label="Créer le trimestre" class="btn-primary" type="submit" spinner="save"
                                icon="o-paper-airplane" />
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

</div>
