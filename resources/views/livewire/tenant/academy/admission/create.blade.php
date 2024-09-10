<?php
use Spatie\LivewireFilepond\WithFilePond;
use App\Models\Cycle;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFilePond;
    use Toast;
    use WithFileUploads;

    // utils depends
    public $niveauxs = [];

    #[Rule('nullable|image|max:1024')]
    public $photo;

    #[Rule('required')]
    public ?int $cycle_searchable_id = null;

    // Options list
    public Collection $cyclesSearchable;

    public $file;

    #[Rule('required|max:10000')]
    public $document_justificatif;

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

    // get niveaux by cycle
    public function updatedCycleSearchableId($cycle_id)
    {
        $this->niveauxs = Niveau::where('cycle_id', $cycle_id)->get();
    }
}; ?>

<div>
    <x-header title="Novelle demande" separator>
        <x-slot:actions>
            <x-button icon="o-arrow-left" class="btn-ghost" label="Back to list demandes" link="/academy/admissions" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="save">
        {{--  Basic section  --}}
        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Infos personnelles" subtitle="Informations Personnelles de l'Élève" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <div class="grid-cols-3">
                    <x-file wire:model="file" accept="image/png" crop-after-change>
                        <img src="{{ $user->avatar ?? 'https://flow.mary-ui.com/images/empty-user.jpg' }}"
                            class="h-40 rounded-lg" />
                    </x-file>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 sm:grid-cols-1 mb-3">
                    {{-- <x-filepond::upload wire:model="file" /> --}}
                    <x-input wire:model.defer="demandeur.nom" label="Nom" icon="o-user" />
                    <x-input wire:model.defer="demandeur.prenom" label="Prénom" icon="o-user" />
                    <x-datepicker label="Date de naissance" wire:model="date_naissance" icon="o-calendar" />
                    <x-input wire:model.defer="lieu_naissance" label="Lieu de naissance" />

                    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                        <input id="bordered-radio-1" type="radio" value="" name="bordered-radio"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="bordered-radio-1"
                            class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Homme</label>
                    </div>
                    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                        <input checked id="bordered-radio-2" type="radio" value="" name="bordered-radio"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="bordered-radio-2"
                            class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Femme</label>
                    </div>

                </div>
                <select class="w-full select select-primary mt-3 mb-3" wire:model="ecole_type">
                    <option disabled selected>Nationalité </option>
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                    <option value="other">Autre</option>
                </select>
                <x-input wire:model.defer="demandeur.nom" label="Adresse exacte" />
                <div class="grid lg:grid-cols-2 gap-3 sm:grid-cols-1 mb-3">
                    <x-input wire:model.defer="phone" label="Télèphone" />
                    <x-input wire:model.defer="email" label="Email" />

                </div>
            </div>
        </div>

        {{--  Details section --}}
        <hr class="my-5" />

        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Informations Scolaires" subtitle="Informations Scolaires" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-input label="Établissement précédent" />
                {{-- <x-input label="Niveau scolaire précédent" /> --}}
                <x-choices label="Cycle précédent ?" wire:model.live="cycle_searchable_id" :options="$cyclesSearchable" single
                    searchable />
                <x-choices-offline label="Classe précédent" wire:model.live="niveau_id" :options="$niveauxs"
                    option-label="name" height="max-h-96" single searchable />
                <x-file wire:model="document_justificatif" label="Certificat de scolarite" hint="Only PDF"
                    accept="application/pdf" />
                <x-filepond::upload wire:model="file" />
                <x-choices label="Cycle demandée ?" wire:model.live="cycle_searchable_id" :options="$cyclesSearchable" single
                    searchable />
                <x-choices-offline label="Classe demandée" wire:model.live="niveau_id" :options="$niveauxs"
                    option-label="name" height="max-h-96" single searchable />
            </div>
        </div>

        <hr class="my-5" />

        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Père" subtitle="Informations du pere" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-input label="Nom du père " />
                <x-input label="Prénom du père" />
                <x-input label="Telephone" />
                <x-input label="Email" />
                <x-input label="Profession" hint="(profession actuelle du père)" />
            </div>
        </div>

        <hr class="my-5" />

        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Mère" subtitle="Informations de la mère" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-input label="Nom " />
                <x-input label="Prénom" />
                <x-input label="Telephone" />
                <x-input label="Email" />
                <x-input label="Profession" hint="(profession actuelle de la mère)" />
            </div>
        </div>

        <hr class="my-5" />

        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Médicales" subtitle="Informations Médicales" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-textarea label="Antécédents médicaux" wire:model="bio" placeholder="Your story ..."
                    hint="Max 1000 chars" rows="3" />
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Annuler" link="/frais/admissions" />
            <x-button label="Enregistrer la demande" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
