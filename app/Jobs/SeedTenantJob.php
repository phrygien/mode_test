<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SeedTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tenant;
    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
        $this->user = Auth::user();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Créer l'utilisateur pour le tenant
        $this->tenant->run(function () {
            User::create([
                "name" => $this->user->name,
                "email" => $this->user->email,
                "password" => Hash::make($this->tenant->password),
            ]);
        });
    }
}
