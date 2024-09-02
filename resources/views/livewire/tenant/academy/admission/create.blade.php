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
    <x-header title="Novelle demande" separator />
    {{-- <x-form wire:submit="save">
        <div class="grid gap-5 lg:grid-cols-2">
            <div>

                <div class="col-span-3 grid gap-3">
                    <x-filepond::upload wire:model="file" />
                    <x-card class="mb-4">
                        <div class="grid lg:grid-cols-2 gap-3 sm:grid-cols-1 mb-3">
                            <x-input wire:model.defer="demandeur.nom" label="Nom" />
                            <x-input wire:model.defer="demandeur.prenom" label="Prénom" />
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
                            <option disabled selected>Nationalite ?</option>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                            <option value="other">Autre</option>
                        </select>
                        <div class="space-y-4">
                            <x-input wire:model.defer="demandeur.nom" label="Numéro CIN" />
                            <x-markdown wire:model="adresse" label="Adresse exacte" />
                        </div>
                    </x-card>
                    <x-card class="mb-4">
                        <div class="space-y-4">
                            <x-input label="Acien ecole" />
                        </div>
                    </x-card>
                </div>
            </div>
            <div>
                <x-card class="mb-4">
                    <div class="space-y-4">
                        <x-choices label="Pour quelle cycle ?" wire:model.live="cycle_searchable_id" :options="$cyclesSearchable"
                            single searchable />
                        <x-choices-offline label="Niveau" wire:model.live="niveau_id" :options="$niveauxs"
                            option-label="name" height="max-h-96" single searchable />
                    </div>
                </x-card>
            </div>
        </div>
        <x-slot:actions>
            <x-button label="Annuler" link="/frais/admissions" />
            <x-button label="Sauvegarder" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form> --}}
    <x-form wire:submit="save">
        {{--  Basic section  --}}
        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Infos personnelles" subtitle="Informations Personnelles de l'Élève" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-file label="Avatar" wire:model="photo" accept="image/png, image/jpeg" crop-after-change>
                    <img src="{{ $user->avatar ?? 'https://flow.mary-ui.com/images/empty-user.jpg' }}"
                        class="h-40 rounded-lg" />
                </x-file>
                <div class="grid lg:grid-cols-2 gap-3 sm:grid-cols-1 mb-3">
                    <x-input wire:model.defer="demandeur.nom" label="Nom" />
                    <x-input wire:model.defer="demandeur.prenom" label="Prénom" />
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
                <x-input label="Niveau scolaire actuel" />
                <x-filepond::upload wire:model="file" />
                <x-choices label="Cycle demandée ?" wire:model.live="cycle_searchable_id" :options="$cyclesSearchable" single
                    searchable />
                <x-choices-offline label="Classe demandée" wire:model.live="niveau_id" :options="$niveauxs"
                    option-label="name" height="max-h-96" single searchable />
                <x-file wire:model="document_justificatif" label="Documents justificatifs" hint="Only PDF"
                    accept="application/pdf" />
            </div>
        </div>

        <hr class="my-5" />

        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Parents" subtitle="Informations sur la Famille" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-input label="Nom et prénom du père " />
                <x-input label="Nom et prénom de la mère" />
                <x-input label="Profession des parents" hint="(profession actuelle du père et de la mère)" />
                <x-input label="Adresse des parents" hint="(modifier si différente de celle de l'élève)" />
                <x-input label="Téléphone des parents" hint="numéro de contact des parents ou tuteurs" />
                <x-input label="Email des parents" hint="adresse email des parents ou tuteurs" />
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
            <x-button label="Valider demande" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
