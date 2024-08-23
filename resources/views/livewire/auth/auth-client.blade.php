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
        if ($user->state != 'active') {
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
        <div class="inline drawer lg:grid lg:drawer-open">
            <input id="" type="checkbox" class="drawer-toggle">
            <div class="w-full p-5 mx-auto drawer-content lg:px-10 lg:py-5">

                <div class="mx-auto mt-20 md:w-96">
                    <a href="/auth/login" wire:navigate="">
                        <div class="mb-8 hidden-when-collapsed">
                            <div class="flex gap-2">
                                <img src="https://flow.mary-ui.com/images/flow.png" width="30" class="mt-1">
                                <span
                                    class="mr-3 text-3xl font-bold text-transparent bg-gradient-to-r from-purple-500 to-pink-300 bg-clip-text ">
                                    flow
                                </span>
                            </div>
                        </div>

                        <div class="display-when-collapsed hidden mx-5 mt-4 lg:mb-6 h-[28px]">
                            <img src="https://flow.mary-ui.com/images/flow.png" width="30" class="h-8">
                        </div>
                    </a>
                    <x-form wire:submit="submit" class="grid grid-flow-row gap-3 auto-rows-min">
                        <x-input label="Email" wire:model="email" inline />
                        <x-input label="Mot de passe" wire:model="password" type="password" inline />

                        <x-slot:actions>
                            <x-button label="Connexion" class="btn-primary" type="submit" spinner="submit"
                                icon="o-paper-airplane" />
                        </x-slot:actions>
                    </x-form>

                </div>

                <div class="flex justify-center mt-20">
                    <a href="/support-us" wire:key="mary2058fb1d87b7edda012a0fbb32d38d16" type="button"
                        class="normal-case btn btn-ghost" wire:navigate="">

                        <span class="block">

                            <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"></path>
                            </svg></span><span class="">
                            Source code
                        </span></a>
                    <a href="https://mary-ui.com" wire:key="mary3e2bccb6feb2e70216e3258d8a32887a" type="button"
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
