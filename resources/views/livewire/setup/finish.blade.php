<?php

use Livewire\Volt\Component;
use App\Models\Province;
use App\Models\Region;
use App\Models\District;
use App\Models\Commune;
use App\Models\School;
use App\Models\Abonnement;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Illuminate\Support\Collection;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    // utils class
    public $regions = [];
    public $districts = [];
    public $communes = [];

    #[Validate(['required', 'max:10', 'min:5'])]
    public string $tenant_name = '';

    #[Validate(['required', 'unique:tenants,email', 'max:255'])]
    public string $tenant_email = '';

    #[Validate(['required', 'min:5'])]
    public string $ecole_name = '';

    #[Validate(['required', 'max:255'])]
    public string $ecole_slug = '';

    #[Validate(['required', 'max:255'])]
    public string $ecole_type = '';

    #[Validate(['required', 'max:255'])]
    public string $ecole_email = '';

    #[Validate(['required', 'max:255'])]
    public string $ecole_phone = '';

    #[Validate(['required', 'max:255'])]
    public ?int $ecole_province = null;

    #[Validate(['required', 'max:255'])]
    public $ecole_region = '';

    #[Validate(['required', 'max:255'])]
    public $ecole_district = '';

    #[Validate(['required', 'max:255'])]
    public $ecole_commune = '';

    #[Validate(['required', 'max:255'])]
    public string $ecole_adresse = '';

    #[Validate(['required', 'max:10'])]
    public string $domaine = '';

    // Options list
    public Collection $provincesSearchable;

    // get regions by province id
    public function updatedEcoleProvince($province_id)
    {
        $this->regions = Region::where('id_province', $province_id)->get();
    }

    // get district by region id
    public function updatedEcoleRegion($region_id)
    {
        $this->districts = District::where('id_region', $region_id)->get();
    }

    // get district by region id
    public function updatedEcoleDistrict($district_id)
    {
        $this->communes = Commune::where('id_district', $district_id)->get();
    }

    // Also called as you type
    public function searchProvince(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Province::where('id', $this->ecole_province)->get();

        $this->provincesSearchable = Province::query()
            ->where('nom', 'like', "%$value%")
            ->orderBy('nom')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    public function mount(): void
    {
        $this->searchProvince();

        $hasTenant = Tenant::where('user_id', Auth::user()->id)->first();
        if ($hasTenant) {
            $this->success('Tenant created', 'You were redirected to another url ...', redirectTo: '/accueil');
        }
    }
    // submit demande
    public function submit()
    {
        ini_set('max_execution_time', 300); // Augmente à 120 secondes

        $this->validate();

        try {
            //DB::beginTransaction();
            //create tenant
            $tenant = Tenant::create([
                'id' => $this->tenant_name,
                'name' => $this->tenant_name,
                'email' => $this->tenant_email,
                'user_id' => Auth::user()->id,
            ]);

            //create domain for the tenant
            $tenant->domains()->create([
                'domain' => $this->domaine . '.' . config('app.domain'),
            ]);

            // create etablissement
            $etablissement = School::create([
                'name' => $this->ecole_name,
                'slug' => $this->ecole_slug,
                'type' => $this->ecole_type,
                'email' => $this->ecole_email,
                'phone' => $this->ecole_phone,
                'province_id' => $this->ecole_province,
                'region_id' => $this->ecole_region,
                'district_id' => $this->ecole_district,
                'commune_id' => $this->ecole_commune,
                'user_id' => Auth::user()->id,
                'address' => $this->ecole_adresse,
            ]);

            // create subscription
            Abonnement::create([
                'numero_abonnement' => $this->tenant_name,
                'date_debut_abonnement' => now(),
                'date_fin_abonnement' => now()->addDays(7),
                'plan_id' => 1,
                'is_trial' => true,
                'is_active' => true,
                'is_paid' => false,
                'user_id' => Auth::user()->id,
                'trial_ends_at' => now()->addDays(7),
            ]);

            //DB::commit();
            $this->success('Subscription created', 'You were redirected to another url ...', redirectTo: '/accueil');
        } catch (\Exception $e) {
            //DB::rollBack();
            dd($e);
            $this->toast('error', $e->getMessage());
        }
    }

    /*public function with(): array
    {
        return [
            'provinces' => Province::all(),
        ];
    }*/
}; ?>

<div>
    <x-header title="Soumettre la demande" separator>
        {{-- <x-slot:actions>
            <x-theme-toggle class="btn btn-circle btn-ghost" />
        </x-slot:actions> --}}
    </x-header>
    <x-form wire:submit="submit">
        <x-card title="Tenant Information" class="mb-4">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-input label="Tenant Name" wire:model="tenant_name" icon="o-globe-americas" />
                </div>
                <div class="w-full">
                    <x-input label="Tenant Email" wire:model="tenant_email" icon="o-globe-americas" />
                </div>
            </div>
        </x-card>

        <x-card title="School Information" class="mb-4">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-input label="Nom école" wire:model="ecole_name" icon="o-building-office-2" />
                </div>
                <div class="w-full">
                    <x-input label="Abreviation école" wire:model="ecole_slug" icon="o-building-office-2" />
                </div>
                <div class="w-full">
                    <x-input label="Email" wire:model="ecole_email" icon="o-envelope" />
                </div>
                <div class="w-full">
                    <x-input label="Télèphone" wire:model="ecole_phone" icon="o-phone" />
                </div>
                <div class="w-full">
                    <select class="select select-primary w-full" wire:model="ecole_type">
                        <option disabled selected>Type?</option>
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                        <option value="other">Autre</option>
                    </select>
                </div>

            </div>
        </x-card>

        <x-card title="Localisation" class="mb-4">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-choices label="Province" wire:model.live="ecole_province" :options="$provincesSearchable" option-label="nom"
                        icon="o-map-pin" height="max-h-96" hint="Le province ou c'est situe l'école" single />
                </div>
                <div class="w-full">
                    <x-choices-offline label="Region" wire:model.live="ecole_region" :options="$regions"
                        option-label="nom" icon="o-map-pin" height="max-h-96" single searchable />
                </div>
                <div>
                    <x-choices-offline label="District" wire:model.live="ecole_district" :options="$districts"
                        option-label="libelle" icon="o-map-pin" height="max-h-96" single searchable />
                </div>
                <div>
                    <x-choices-offline label="Commune" wire:model.live="ecole_commune" :options="$communes"
                        option-label="nom" icon="o-map-pin" height="max-h-96" single searchable />
                </div>
                <div class="sm:col-span-2">
                    <x-textarea label="Adresse exacte" wire:model="ecole_adresse" placeholder="Saisissez l'adresse ..."
                        hint="Adresse exacte de l'école" rows="5" />
                </div>
            </div>
        </x-card>
        <x-slot:actions>
            <x-button label="Soumettre" class="btn-primary" type="submit" spinner="submit" icon="o-paper-airplane" />
        </x-slot:actions>
    </x-form>
    {{-- <x-form wire:submit="submit" class="space-x-4">
        <div class="space-y-4">
            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <x-card title="Tenant Information" separator class="mb-4">
                        <div class="space-y-4">
                            <x-input label="Tenant Name" wire:model="tenant_name" />
                            <x-input label="Tenant Email" wire:model="tenant_email" />
                        </div>
                    </x-card>

                    <x-card title="School Information" separator class="mb-4">
                        <div class="space-y-4">
                            <x-input label="Nom école" wire:model="ecole_name" />
                            <x-input label="Abreviation école" wire:model="ecole_slug" />
                            <select class="select select-primary w-full" wire:model="ecole_type">
                                <option disabled selected>Type?</option>
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                                <option value="other">Autre</option>
                            </select>
                            <x-input label="Email" wire:model="ecole_email" />
                            <x-input label="Télèphone" wire:model="ecole_phone" />
                        </div>
                    </x-card>
                </div>
                <div>
                    <x-card title="Adresse de l'école" separator class="mb-4 ">
                        <div class="space-y-4">
                            <div class="w-full">
                                <x-choices label="Province" wire:model.live="ecole_province" :options="$provincesSearchable"
                                    option-label="nom" icon="o-map-pin" height="max-h-96"
                                    hint="Le province ou c'est situe l'école" single />
                            </div>
                            <div class="w-full">
                                <x-choices-offline label="Region" wire:model.live="ecole_region" :options="$regions"
                                    option-label="nom" icon="o-map-pin" height="max-h-96" single searchable />
                            </div>
                            <div>
                                <x-choices-offline label="District" wire:model.live="ecole_district" :options="$districts"
                                    option-label="libelle" icon="o-map-pin" height="max-h-96" single searchable />
                            </div>
                            <div>
                                <x-choices-offline label="Commune" wire:model.live="ecole_commune" :options="$communes"
                                    option-label="nom" icon="o-map-pin" height="max-h-96" single searchable />
                            </div>
                            <x-textarea label="Adresse exacte" wire:model="ecole_adresse"
                                placeholder="Saisissez l'adresse ..." hint="Adresse exacte de l'école" rows="5" />
                        </div>
                    </x-card>
                </div>

            </div>
        </div>
        <x-slot:actions>
            <x-button label="Soumettre" class="btn-primary" type="submit" spinner="submit" icon="o-paper-airplane" />
        </x-slot:actions>
    </x-form> --}}
</div>
