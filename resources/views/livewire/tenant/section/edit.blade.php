<?php
use App\Models\Niveau;
use App\Models\Section;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;

    public Section $section;

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
        $this->fill($this->section);
        $this->search();
        $this->niveau_searchable_id = $this->section->niveau_id;
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

    // update section
    public function save()
    {
        $data = $this->validate();
        $this->section->update([
            'niveau_id' => $data['niveau_searchable_id'],
        ]);
        $this->success('Mise à jour avec succès.', redirectTo: '/configurations/sections');
    }

    // delete niveau
    public function delete()
    {
        $this->section->delete();
        $this->success('Suppression avec succès.', redirectTo: '/configurations/sections');
    }

    public function with(): array
    {
        return [
            'niveausSearchable' => Niveau::all(), // Available cycle
        ];
    }
}; ?>

<div>
    <div>
        <x-header title="Section {{ $section->name }}" separator>
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
                        {{-- Notice `searchable` + `single` --}}
                        <x-choices label="Niveau" wire:model="niveau_searchable_id" :options="$niveausSearchable" single searchable />
                        <x-input wire:model="name" label="Nom de la section" />
                        <x-input wire:model="abreviation" label="Abreviation" hint="ex: 6e A, 1e B" />
                        <x-slot:actions>
                            <x-button label="Annuler" link="/configurations/sections" />
                            <x-button label="Mettre a jour la section" class="btn-primary" type="submit" spinner="save"
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
