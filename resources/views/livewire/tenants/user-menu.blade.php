<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{on, state};

state(['user' => fn() => Auth::user()]);
on(['user-updated' => fn() => $this->user->refresh()]);

$logout = function () {
    Auth::logout();

    $this->redirect(url: route('pages:tenants:auth:login'));
}; ?>

<x-list-item :item="$user" value="name" no-separator no-hover class="-mx-2 !-my-2 rounded">
    <x-slot:avatar>
        <div class="avatar online placeholder">
            <div class="bg-neutral text-neutral-content w-12 rounded-full">
                <span class="text-xl">AM</span>
            </div>
        </div>
    </x-slot:avatar>
    <x-slot:actions>
        {{-- Custom trigger  --}}
        <x-dropdown>
            <x-slot:trigger>
                <x-button icon="o-cog-6-tooth" class="btn-circle  btn-ghost btn-sm" />
            </x-slot:trigger>

            <x-menu-item title="Deconnecter" icon="o-power" wire:click="logout" />
            <x-menu-item title="Theme" icon="o-swatch" @click="$dispatch('mary-toggle-theme')" />
            <x-theme-toggle class="hidden" />
        </x-dropdown>
        {{-- <x-button
            wire:click="logout"
            icon="o-power"
            class="btn-circle btn-ghost btn-xs"
            tooltip-left="Sign out"
        /> --}}
    </x-slot:actions>
</x-list-item>
