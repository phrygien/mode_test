<?php
use Livewire\WithPagination;
use App\Models\AnneeScolaire;
use App\Models\Trimestre;
use Mary\Traits\Toast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;

new class extends Component {
    use Toast;
    use WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public int $annee_scolaire_id = 0;

    public array $sortBy = ['column' => 'debut', 'direction' => 'asc'];

    // Table headers
    public function headers(): array
    {
        return [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'debut', 'label' => 'Date debut', 'class' => 'w-64'], ['key' => 'fin', 'label' => 'Date fin', 'class' => 'w-64'], ['key' => 'anneescolaire.name', 'label' => 'Annee scolaire', 'class' => 'w-64']];
    }

    public function trimestres(): LengthAwarePaginator
    {
        return Trimestre::query()
            ->with(['anneescolaire'])
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->when($this->annee_scolaire_id, fn(Builder $q) => $q->where('annee_scolaire_id', $this->niveau_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10); // No more `->get()`
    }

    public function with(): array
    {
        return [
            'trimestres' => $this->trimestres(),
            'headers' => $this->headers(),
            'anneescolaires' => AnneeScolaire::all(),
        ];
    }

    // generate trimestre of the year
    public function generateTrimestre()
    {
        // Récupérer l'année scolaire en cours
        $annee = AnneeScolaire::where('is_open', true)->first();
        $debut = Carbon::parse($annee->debut); // Convertir la date de début en instance de Carbon
        $fin = Carbon::parse($annee->fin); // Convertir la date de fin en instance de Carbon

        // Calculer la durée totale de l'année scolaire en jours
        $dureeAnnee = $debut->diffInDays($fin);

        // Diviser cette durée en trois parties égales pour les trimestres
        $dureeTrimestre = $dureeAnnee / 3;

        // Générer les dates de début et de fin pour chaque trimestre
        $trimestres = [];
        $nomsTrimestres = ['Premier Trimestre', 'Deuxième Trimestre', 'Troisième Trimestre'];

        for ($i = 0; $i < 3; $i++) {
            $trimestreDebut = $debut->copy()->addDays($dureeTrimestre * $i);
            $trimestreFin = $trimestreDebut->copy()->addDays($dureeTrimestre - 1);

            // S'assurer que le dernier trimestre se termine à la fin de l'année scolaire
            if ($i == 2) {
                $trimestreFin = $fin;
            }

            $trimestres[] = [
                'nom' => $nomsTrimestres[$i],
                'debut' => $trimestreDebut,
                'fin' => $trimestreFin,
            ];
        }

        // Enregistrer les trimestres dans la base de données
        foreach ($trimestres as $trimestre) {
            Trimestre::create([
                'annee_scolaire_id' => $annee->id,
                'nom' => $trimestre['nom'],
                'debut' => $trimestre['debut'],
                'fin' => $trimestre['fin'],
            ]);
        }

        $this->success('Trimestres générés avec succès');
    }
}; ?>

<div>
    <x-header title="Trimestres" subtitle="Gestion des trimestres">
        <x-slot:actions>
            <x-theme-toggle class="btn btn-circle btn-ghost" />
        </x-slot:actions>
    </x-header>
    @if (count($trimestres) > 0)
        <x-card>
            @foreach ($trimestres as $trimestre)
                <x-list-item :item="$trimestre" link="/docs/installation" value="nom" sub-value="fin" />
            @endforeach
        </x-card>
    @else
        <div
            class="flex flex-col bg-white border shadow-sm min-h-60 rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="flex flex-col items-center justify-center flex-auto p-4 md:p-5">
                <svg class="text-gray-500 size-10 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" x2="2" y1="12" y2="12"></line>
                    <path
                        d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                    </path>
                    <line x1="6" x2="6.01" y1="16" y2="16"></line>
                    <line x1="10" x2="10.01" y1="16" y2="16"></line>
                </svg>
                <p class="mt-2 text-sm text-gray-800 dark:text-neutral-300">
                    No Data
                </p>
                <p class="mt-3">
                    <x-button class="btn-primary" label="Generer les trimetres de l'annee sccolaire"
                        wire:click='generateTrimestre' />
                </p>
            </div>
        </div>
    @endif
    {{-- <x-card>
        <x-table :headers="$headers" :rows="$trimestres" :sort-by="$sortBy" with-pagination link="sections/{id}/edit" />
    </x-card> --}}
</div>
