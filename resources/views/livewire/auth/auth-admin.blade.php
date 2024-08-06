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
    use Toast;

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

        // Check if the authenticated user is an admin
        if (!auth()->user()->is_admin) {
            // Log out the user
            $auth->logout();

            throw ValidationException::withMessages([
                'email' => 'Accès non autorisé.',
            ]);
        }

        // Redirect to admin dashboard if the user is an admin
        $this->redirect(route('pages:admin:dashboard'));
    }
}; ?>

<div>
    <div class="bg-white border border-gray-200 shadow-sm mt-7 rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
        <div class="p-4 sm:p-7">
            {{-- <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Authentification</h1>
            </div> --}}

            <div class="mt-5">
                <div
                    class="flex items-center py-3 text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">
                    e-ping Admin</div>

                <!-- Form -->
                <x-form wire:submit="submit">
                    <x-input label="Name" wire:model="email" icon="o-user" inline />
                    <x-input label="Mot de passe" wire:model="password" icon="o-lock-closed" inline type="password" />

                    <x-slot:actions>
                        <x-button label="Connexion" class="btn-primary" type="submit" spinner="submit"
                            icon="o-paper-airplane" />
                    </x-slot:actions>
                </x-form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</div>
