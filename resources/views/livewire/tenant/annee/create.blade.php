<?php
use Mary\Traits\Toast;
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

    public function save(): void
    {
        $this->validate();

        AnneeScolaire::create([
            'name' => $this->name,
            'debut' => $this->debut,
            'fin' => $this->fin,
        ]);
        $this->success('Donneés sauvegardees avec succès.', redirectTo: '/configurations/annees');

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
                    <x-datetime label="Debut" wire:model="debut" icon="o-calendar" />
                    <x-datetime label="Fin" wire:model="fin" icon="o-calendar" />
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
