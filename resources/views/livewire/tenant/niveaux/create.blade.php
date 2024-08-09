<?php

use App\Models\Cycle;
use App\Models\Niveau;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public ?int $cycle_searchable_id = null;

    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public string $abreviation = '';

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

    // create niveau
    public function save()
    {
        $this->validate();
        Niveau::create([
            'cycle_id' => $this->cycle_searchable_id,
            'name' => $this->name,
            'abreviation' => $this->abreviation,
        ]);

        $this->reset();
        $this->success('Niveau créé avec succès.', redirectTo: '/configurations/niveaux');
    }
}; ?>

<div>
    <div>
        <x-header title="Créer niveau" separator>
            <x-slot:actions>
                <x-theme-toggle class="btn btn-circle btn-ghost" />
            </x-slot:actions>
        </x-header>

        <!-- Grid stuff from Tailwind -->
        <div class="grid gap-5 lg:grid-cols-2">
            <x-card>
                <div>
                    <x-form wire:submit="save">
                        {{-- Notice `searchable` + `single` --}}
                        <x-choices label="Cycle" wire:model="cycle_searchable_id" :options="$cyclesSearchable" single searchable />
                        <x-input wire:model="name" label="Nom de niveau" />
                        <x-input wire:model="abreviation" label="Abreviation" hint="ex: CM1,6em, TS1" />
                        <x-slot:actions>
                            <x-button label="Annuler" link="/configurations/niveaux" />
                            <x-button label="Créer le niveau" class="btn-primary" type="submit" spinner="save"
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
