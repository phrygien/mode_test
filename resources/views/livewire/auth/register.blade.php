<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    #[Validate('required|max:255')]
    public string $name;

    #[Validate('required|max:255')]
    public string $last_name;

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email;

    #[Validate('required|min:6|same:confirm_password')]
    public string $password;

    #[Validate('required|min:6|same:password')]
    public string $confirm_password;

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            //'etablissement' => $this->etablissement,
        ]);

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        Auth::attempt($credentials);

        $this->success('Bienvenue ' . $this->name . 'ouverture de compte avec succees');

        $this->redirect(url: route('pages:setup'));
    }
}; ?>

<div>
    <!-- Hero -->
    <div class="relative bg-gradient-to-bl from-purple-400 via-transparent dark:from-purple-400 dark:via-transparent">
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <x-header title="Soucription" />
            <!-- Grid stuff from Tailwind -->
            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <x-form wire:submit="save">
                        <x-card title="Infos personnelles">
                            <div class="space-y-4">
                                <x-input label="Nom" wire:model="name" icon="o-user-circle" />
                                <x-input label="Prenoms" wire:model="last_name" icon="o-user-circle" />
                                <x-input label="Telephone" wire:model="telephone" icon="o-device-phone-mobile" />
                            </div>

                        </x-card>

                        <x-card title="Accées et securité">
                            <div class="space-y-4">
                                <x-input label="Adresse e-mail" wire:model="email" icon="o-envelope" />
                                <x-input label="Mot de passe" wire:model="password" icon="o-eye" type="password" />
                                <x-input label="Confirmation mot de passe" wire:model="confirm_password" icon="o-eye"
                                    type="password" />
                            </div>
                        </x-card>
                        <x-slot:actions>
                            <x-button label="Annuler" />
                            <x-button label="Soucir" class="btn-primary" type="submit" spinner="save"
                                icon="o-paper-airplane" />
                        </x-slot:actions>
                    </x-form>
                </div>
                <div>
                    {{-- Get a nice picture from `StorySet` web site --}}
                    <img src="https://flow.mary-ui.com/images/edit-form.png" width="300" class="mx-auto" />
                </div>
            </div>
        </div>
        <!-- End Clients Section -->
    </div>
    <!-- End Hero -->
</div>
