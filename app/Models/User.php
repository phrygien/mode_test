<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property null|string $remember_token
 * @property null|CarbonInterface $email_verified_at
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property null|CarbonInterface $deleted_at
 * @property Collection<Team> $teams
 */
final class User extends Authenticatable
{
    use HasFactory;
    use HasUlids;
    use Notifiable;
    use SoftDeletes;

    /** @var array<int,string> */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /** @var array<int,string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return HasMany<Team> */
    public function teams(): HasMany
    {
        return $this->hasMany(
            related: Team::class,
            foreignKey: 'user_id',
        );
    }

    /** @return HasMany<Department> */
    public function departments(): HasMany
    {
        return $this->hasMany(
            related: Department::class,
            foreignKey: 'user_id',
        );
    }

    /** @return HasOne<Employee> */
    public function employee(): HasOne
    {
        return $this->hasOne(
            related: Employee::class,
            foreignKey: 'user_id',
        );
    }

    /** @return array<string,string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permission)
    {
        $abonnement = $this->activeAbonnement;

        if ($abonnement && $abonnement->role->permissions->contains('name', $permission)) {
            return true;
        }

        return false;
    }

    // Optionally, a helper method to get role names as an array
    public function getRoleNames()
    {
        return $this->roles->pluck('name')->toArray();
    }

    public function abonnements(): HasMany
    {
        return $this->hasMany(Abonnement::class);
    }

    public function activeAbonnement(): HasOne
    {
        return $this->hasOne(Abonnement::class)->where('statut', 1)->where('is_active', true);
    }

    public function UserhasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }
        return false;
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class); // Assurez-vous que c'est `hasOne` si un utilisateur a un seul locataire
    }
}
