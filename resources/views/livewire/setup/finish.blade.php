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
    public $ecole_province = '';

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

    public function mount(): void
    {
        $hasTenant = Tenant::where('user_id', Auth::user()->id)->first();
        if ($hasTenant) {
            $this->success('Tenant created', 'You were redirected to another url ...', redirectTo: '/accueil');
        }
    }
    // submit demande
    public function submit()
    {
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

    public function with(): array
    {
        return [
            'provinces' => Province::all(),
        ];
    }
}; ?>

<div>
    <x-header title="Soumettre une demande" separator>
        <x-slot:actions>
            <x-theme-toggle class="btn btn-circle btn-ghost" />
        </x-slot:actions>
    </x-header>
    <div class="space-y-4">
        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <!-- Card Section -->
                <div class="max-w-4xl">
                    <!-- Card -->
                    <div class="p-4 bg-white shadow rounded-xl sm:p-7 dark:bg-neutral-900">
                        <form wire:submit='submit'>
                            <!-- Section -->
                            <div
                                class="grid gap-2 py-8 border-t border-gray-200 sm:grid-cols-12 sm:gap-4 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                                <div class="sm:col-span-12">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                        Location details
                                    </h2>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-3">
                                    <label for="af-submit-application-full-name"
                                        class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                        Nom de location
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <div class="sm:flex">
                                        <input id="af-submit-application-full-name" type="text"
                                            wire:model.live='tenant_name'
                                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    </div>
                                    <div>
                                        @error('tenant_name')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-3">
                                    <label for="af-submit-application-email"
                                        class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                        Email
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <div class="sm:flex">
                                        <input id="af-submit-application-email" type="email"
                                            wire:model.live='tenant_email'
                                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    </div>
                                    <div>
                                        @error('tenant_email')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Section -->

                            <!-- Section -->
                            <div
                                class="grid gap-2 py-8 border-t border-gray-200 sm:grid-cols-12 sm:gap-4 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                                <div class="sm:col-span-12">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                        Etablissement details
                                    </h2>
                                </div>
                                <!-- End Col -->
                                <div class="sm:col-span-3">
                                    <label for="af-submit-application-email"
                                        class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                        Ecole Name
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <div class="sm:flex">
                                        <input id="af-submit-application-email" type="text"
                                            wire:model.live='ecole_name'
                                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    </div>
                                    <div>
                                        @error('ecole_name')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->
                                <div class="sm:col-span-3">
                                    <label for="af-submit-application-email"
                                        class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                        Abreviation
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <div class="sm:flex">
                                        <input id="af-submit-application-email" type="text"
                                            wire:model.live='ecole_slug'
                                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    </div>
                                    <div>
                                        @error('ecole_slug')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->
                                {{-- <div class="sm:col-span-3">
                                    <label for="af-submit-application-full-name"
                                        class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                        Nom & abreviation
                                    </label>
                                </div> --}}
                                <!-- End Col -->

                                {{-- <div class="sm:col-span-9">
                                    <div class="sm:flex">
                                        <input id="af-submit-application-full-name" type="text"
                                            wire:model.live='ecole_name' placeholder='Nom ecole'
                                            class="relative block w-full px-3 py-2 -mt-px text-sm border-gray-200 shadow-sm pe-11 -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <input type="text" wire.model.live='ecole_slug' placeholder="abreviation"
                                            class="relative block w-full px-3 py-2 -mt-px text-sm border-gray-200 shadow-sm pe-11 -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    </div>
                                    <div>
                                        @error('ecole_name')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                        @error('ecole_slug')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="sm:col-span-3">
                                    <label for="af-account-gender-checkbox"
                                        class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                        Type
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <div class="sm:flex">
                                        <label for="af-account-gender-checkbox"
                                            class="relative flex w-full px-3 py-2 -mt-px text-sm border border-gray-200 shadow-sm -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                            <input type="radio" wire:model.live='ecole_type' value="Private"
                                                name="af-account-gender-checkbox"
                                                class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-500 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                id="af-account-gender-checkbox" checked>
                                            <span
                                                class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Private</span>
                                        </label>

                                        <label for="af-account-gender-checkbox-female"
                                            class="relative flex w-full px-3 py-2 -mt-px text-sm border border-gray-200 shadow-sm -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                            <input type="radio" wire:model.live='ecole_type' value="Public"
                                                name="af-account-gender-checkbox"
                                                class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-500 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                id="af-account-gender-checkbox-female">
                                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Public</span>
                                        </label>

                                        <label for="af-account-gender-checkbox-other"
                                            class="relative flex w-full px-3 py-2 -mt-px text-sm border border-gray-200 shadow-sm -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                            <input type="radio" wire:model.live='ecole_type' value="Autre"
                                                name="af-account-gender-checkbox"
                                                class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-500 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                id="af-account-gender-checkbox-other">
                                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Autre</span>
                                        </label>
                                    </div>

                                    @error('ecole_type')
                                        <span class="text-red-500 error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Col -->
                                <!-- End Col -->
                                <div class="sm:col-span-3">
                                    <label for="af-submit-application-email"
                                        class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                        Email
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <input id="af-submit-application-email" type="email" wire:model.live='ecole_email'
                                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                                    @error('ecole_email')
                                        <span class="text-red-500 error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-3">
                                    <div class="inline-block">
                                        <label for="af-submit-application-phone"
                                            class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                            Phone
                                        </label>
                                    </div>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <input id="af-submit-application-current-company" type="text"
                                        wire:model.live='ecole_phone'
                                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                                    @error('ecole_phone')
                                        <span class="text-red-500 error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-3">
                                    <div class="inline-block">
                                        <label for="af-submit-application-bio"
                                            class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                            Personal summary
                                        </label>
                                    </div>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <div class="flex flex-col gap-3 sm:flex-row">
                                        <select wire:model.live='ecole_province'
                                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                            <option selected>Province ?</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->nom }}</option>
                                            @endforeach
                                        </select>
                                        <select wire:model.live='ecole_region'
                                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                            <option selected>Region ?</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}">{{ $region->nom }}</option>
                                            @endforeach
                                        </select>
                                        <select wire:model.live='ecole_district'
                                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                            <option selected>District ?</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        @error('ecole_province')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>

                                        @error('ecole_region')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>

                                        @error('ecole_district')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->
                                <div class="sm:col-span-3">
                                    <div class="inline-block">
                                        <label for="af-submit-application-bio"
                                            class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                            Commune
                                        </label>
                                    </div>
                                </div>
                                <!-- End Col -->
                                <div class="sm:col-span-9">
                                    <select wire:model.live='ecole_commune'
                                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option selected>Commune ?</option>
                                        @foreach ($communes as $commune)
                                            <option value="{{ $commune->id }}">{{ $commune->nom }}</option>
                                        @endforeach
                                    </select>
                                    <div>

                                        @error('ecole_commune')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->

                                <!-- End Col -->
                                <div class="sm:col-span-3">
                                    <div class="inline-block">
                                        <label for="af-submit-application-bio"
                                            class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                            Adresse
                                        </label>
                                    </div>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <textarea id="af-submit-application-bio" wire:model.live='ecole_adresse'
                                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        rows="6" placeholder="Add school adresse here."></textarea>
                                    <div>

                                        @error('ecole_adresse')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Section -->

                            <!-- Section -->
                            <div
                                class="grid gap-2 py-8 border-t border-gray-200 sm:grid-cols-12 sm:gap-4 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                                <div class="sm:col-span-12">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                        Domaine
                                    </h2>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-3">
                                    <label for="af-submit-application-linkedin-url"
                                        class="inline-block text-sm font-medium text-gray-500 mt-2.5 dark:text-neutral-500">
                                        Nom de domaine
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <input id="af-submit-application-linkedin-url" type="text"
                                        wire:model.live='domaine'
                                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <div>

                                        @error('domaine')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-start-4 sm:col-span-8">
                                    <a class="inline-flex items-center text-sm font-medium text-blue-600 gap-x-1 decoration-2 hover:underline focus:outline-none focus:underline dark:text-blue-500"
                                        href="../docs/index.html">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M8 12h8" />
                                            <path d="M12 8v8" />
                                        </svg>
                                        Suggestion
                                    </a>
                                </div>
                            </div>
                            <!-- End Section -->

                            <!-- Section -->
                            <div
                                class="py-8 border-t border-gray-200 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                    Submit application
                                </h2>
                                <p class="mt-3 text-sm text-gray-600 dark:text-neutral-400">
                                    In order to contact you with future jobs that you may be interested in, we need to
                                    store your personal data.
                                </p>
                                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                                    If you are happy for us to do so please click the checkbox below.
                                </p>

                                <div class="flex mt-5">
                                    <input type="checkbox"
                                        class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                        id="af-submit-application-privacy-check">
                                    <label for="af-submit-application-privacy-check"
                                        class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Allow us to process
                                        your personal information.</label>
                                </div>
                            </div>
                            <!-- End Section -->

                            <x-button label="Soumettre" class="btn-primary" type="submit" spinner="submit" />
                        </form>
                    </div>
                    <!-- End Card -->
                </div>
                <!-- End Card Section -->
            </div>
            <div>
                {{-- Get a nice picture from `StorySet` web site --}}
                <img src="https://flow.mary-ui.com/images/edit-form.png" width="300" class="mx-auto" />
            </div>
        </div>
    </div>
</div>
