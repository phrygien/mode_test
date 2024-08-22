<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;

new class extends Component {
    #[Validate(['required', 'email', 'max:255'])]
    public string $email = '';

    #[Validate(['required', 'string', 'max:255'])]
    public string $password = '';

    public function submit(AuthManager $auth): void
    {
        $this->validate();

        if (!$auth->attempt(['email' => $this->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'email' => 'L\'authentification a échoué.',
            ]);
        }

        // Récupérer l'utilisateur authentifié
        $user = $auth->user();

        // Vérifier si l'utilisateur est actif
        if ($user->state == 'inactive') {
            $auth->logout();
            throw ValidationException::withMessages([
                'email' => 'Votre compte est inactif. Veuillez contacter l\'administrateur.',
            ]);
        }

        $this->redirect(url: route('pages:setup'));
    }
}; ?>

<div>
    <main class="w-full mx-auto">
        <div class="drawer inline lg:grid lg:drawer-open">
            <input id="" type="checkbox" class="drawer-toggle">
            <div class="drawer-content w-full mx-auto p-5 lg:px-10 lg:py-5">
                <!-- MAIN CONTENT -->
                <div class="mt-20 md:w-96 mx-auto">
                    <a href="/" wire:navigate="">
                        <!-- Hidden when collapsed -->
                        <div class="hidden-when-collapsed mb-8">
                            <div class="flex gap-2">
                                <img src="https://flow.mary-ui.com/images/flow.png" width="30" class="mt-1">
                                <span
                                    class="font-bold text-3xl mr-3 bg-gradient-to-r from-purple-500 to-pink-300 bg-clip-text text-transparent ">
                                    flow
                                </span>
                            </div>
                        </div>

                        <!-- Display when collapsed -->
                        <div class="display-when-collapsed hidden mx-5 mt-4 lg:mb-6 h-[28px]">
                            <img src="https://flow.mary-ui.com/images/flow.png" width="30" class="h-8">
                        </div>
                    </a>
                    <x-form wire:submit="submit" class="grid grid-flow-row auto-rows-min gap-3">
                        <x-input label="Email" wire:model="email" inline />
                        <x-input label="Mot de passe" wire:model="password" type="password" inline />

                        <x-slot:actions>
                            <x-button label="Connexion" class="btn-primary" type="submit" spinner="submit"
                                icon="o-paper-airplane" />
                        </x-slot:actions>
                    </x-form>

                </div>

                <div class="flex mt-20 justify-center">
                    <!--[if BLOCK]><![endif]--> <a href="/support-us" wire:key="mary2058fb1d87b7edda012a0fbb32d38d16"
                        type="button" class="btn normal-case btn-ghost" wire:navigate="">

                        <span class="block">

                            <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"></path>
                            </svg></span><span class="">
                            Source code
                        </span></a>
                    <!--[if ENDBLOCK]><![endif]--> <!--[if BLOCK]><![endif]--> <a href="https://mary-ui.com"
                        wire:key="mary3e2bccb6feb2e70216e3258d8a32887a" type="button"
                        class="btn normal-case btn-ghost !text-pink-500" target="_blank">
                        <span class="block">

                            <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z">
                                </path>
                            </svg> </span>
                        <span class="">
                            Built with maryUI
                        </span></a>
                </div>
            </div>

        </div>
    </main>
</div>
