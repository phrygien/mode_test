<?php
use Mary\Traits\Toast;
use Carbon\Carbon;
use App\Models\AnneeScolaire;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public $debut = '';

    #[Rule('required')]
    public $fin = '';

    public function updatedDebut($value): void
    {
        // Convertir les dates en objets Carbon
        $debut = Carbon::parse($value);

        // Calculer la date de fin en ajoutant 9 mois à la date de début
        $fin = $debut->copy()->addMonths(9)->subDay()->format('d/m/Y'); // Format 'J/M/Y'

        // Assigner la date de fin formatée à la propriété fin
        $this->fin = $fin;
    }

    public function save(): void
    {
        $this->validate();

        // Convertir la date de début en un objet Carbon
        $debut = Carbon::parse($this->debut);

        // Calculer la date de fin en ajoutant 9 mois à la date de début
        $fin = $debut->copy()->addMonths(9)->subDay()->format('Y-m-d'); // Format 'YYYY-MM-DD'

        // Créer l'année scolaire avec la date de fin calculée
        AnneeScolaire::create([
            'name' => $this->name,
            'debut' => $this->debut,
            'fin' => $fin,
        ]);

        $this->success('Données sauvegardées avec succès.', redirectTo: '/configurations/annees');

        $this->reset();
    }
}; ?>

<div>
    <x-header title="Créer année" separator>
        <x-slot:actions>
            <x-theme-toggle class="btn btn-circle btn-ghost" />
        </x-slot:actions>
    </x-header>

    <!-- Grid stuff from Tailwind -->
    <div class="grid gap-5 lg:grid-cols-2">
        <x-card>
            <div>
                <x-form wire:submit="save">
                    <x-input wire:model="name" label="Name" />
                    <x-datetime label="Debut année scolaire" wire:model.live="debut" icon="o-calendar" />
                    <x-input label="Date fin année scolaire" wire:model="fin" icon="o-calendar" disabled />
                    <x-slot:actions>
                        <x-button label="Annuler" />
                        <x-button label="Créer" class="btn-primary" type="submit" spinner="save"
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
