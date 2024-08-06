<x-layouts.admin title="Admin panel">
    <x-header title="{{ ucfirst(tenant('id')) }} Dashboard">
        <x-slot:actions>
            <x-theme-toggle class="btn btn-circle btn-ghost" />
        </x-slot:actions>
    </x-header>
    <div class="space-y-4">
        <livewire:tenants.stats />
        <livewire:tenants.department-list />
    </div>
</x-layouts.admin>
