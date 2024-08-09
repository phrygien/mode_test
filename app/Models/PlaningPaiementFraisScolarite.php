<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaningPaiementFraisScolarite extends Model
{
    use HasFactory;

    //avoir la liste des jours du mois de debut et fin
    function getFirstMondays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $firstMondays = [];

        while ($start->lessThanOrEqualTo($end)) {
            $firstMonday = $start->copy()->firstOfMonth()->next(Carbon::MONDAY);
            if ($firstMonday->month != $start->month) {
                $firstMonday = $start->firstOfMonth();
            }
            $firstMondays[] = $firstMonday->format('Y-m-d');
            $start->addMonth();
        }

        return $firstMondays;
    }

    // Exemple d'utilisation
// $firstMondays = getFirstMondays('2024-09-01', '2025-06-30');

    public function genererPlaningPaiementFraisScolarite()
    {
        $anneeScolaire = AnneeScolaire::current();
        $firstMondays = getFirstMondays($anneeScolaire->date_debut, $anneeScolaire->date_fin);
        $fraisScolarite = FraisScolarite::where('classe_id', $eleve->classe_id)
            ->where('annee_scolaire_id', $anneeScolaire->id)
            ->first();

        foreach ($firstMondays as $monday) {
            PlanningPaiement::create([
                'eleve_id' => $eleve->id,
                'frais_scolarite_id' => $fraisScolarite->id,
                'mois_concerne' => $monday, // Premier lundi du mois
                'montant_reste' => $fraisScolarite->montant_mensuel,
            ]);
        }

    }
}
