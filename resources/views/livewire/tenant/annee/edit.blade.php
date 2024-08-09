<?php

use App\Models\AnneeScolaire;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    public AnneeScolaire $anneescolaire;

    #[Rule('required')]
    public string $name = '';
    public $debut = '';
    public $fin = '';

    public function mount(AnneeScolaire $annee): void
    {
        $this->fill($this->anneescolaire);
    }

    public function save()
    {
        $data = $this->validate();
        $this->anneescolaire->update($data);
        $this->success('Donneés mises à jour avec succès.', redirectTo: '/configurations/annees');
    }
}; ?>

<div>
    <x-header title="{{ $anneescolaire->name }}" separator>
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
                        <x-button label="Mise a jour" class="btn-primary" type="submit" spinner="save"
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
