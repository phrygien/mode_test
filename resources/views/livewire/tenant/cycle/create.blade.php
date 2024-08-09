<?php

use Mary\Traits\Toast;
use App\Models\Cycle;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public string $code = '';

    public function save(): void
    {
        $this->validate();

        Cycle::create([
            'name' => $this->name,
            'code' => $this->code,
        ]);
        $this->success('Donneés sauvegardees avec succès.', redirectTo: '/configurations/cycles');

        $this->reset();
    }
}; ?>

<div>
    <x-header title="Créer cycle" separator>
        <x-slot:actions>
            <x-theme-toggle class="btn btn-circle btn-ghost" />
        </x-slot:actions>
    </x-header>

    <!-- Grid stuff from Tailwind -->
    <div class="grid gap-5 lg:grid-cols-2">
        <x-card>
            <div>
                <x-form wire:submit="save">
                    <x-input wire:model="name" label="Nom du cycle" />
                    <x-input wire:model="code" label="Code cycle" />
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
