<?php

use App\Models\Section;
use App\Models\Niveau;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public ?int $niveau_searchable_id = null;

    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public string $abreviation = '';

    // Options list
    public Collection $niveausSearchable;

    public function mount()
    {
        // Fill options when component first renders
        $this->search();
    }

    // Also called as you type
    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Niveau::where('id', $this->niveau_searchable_id)->get();

        $this->niveausSearchable = Niveau::query()
            ->where('name', 'like', "%$value%")
            ->orderBy('name')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    // create section
    public function save()
    {
        $this->validate();
        Section::create([
            'niveau_id' => $this->niveau_searchable_id,
            'name' => $this->name,
            'abreviation' => $this->abreviation,
        ]);

        $this->reset();
        $this->success('Section créé avec succès.', redirectTo: '/configurations/sections');
    }
}; ?>

<div>
    <div>
        <x-header title="Créer section" separator>
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
                        <x-choices label="Niveau" wire:model="niveau_searchable_id" :options="$niveausSearchable" single searchable />
                        <x-input wire:model="name" label="Nom de la section" />
                        <x-input wire:model="abreviation" label="Abreviation" hint="ex: 6e A, 1e B" />
                        <x-slot:actions>
                            <x-button label="Annuler" link="/configurations/sections" />
                            <x-button label="Créer la section" class="btn-primary" type="submit" spinner="save"
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
