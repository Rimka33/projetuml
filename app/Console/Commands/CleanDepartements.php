<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Departement;
use App\Models\ChefDepartement;
use Illuminate\Support\Facades\DB;

class CleanDepartements extends Command
{
    protected $signature = 'departement:clean';
    protected $description = 'Nettoie les départements en double';

    public function handle()
    {
        // Sauvegarde les associations chef-département
        $associations = ChefDepartement::all()->map(function ($chef) {
            return [
                'utilisateur_id' => $chef->utilisateur_id,
                'departement_nom' => $chef->departement->nom,
            ];
        });

        // Supprime d'abord les associations
        DB::table('chef_departements')->delete();

        // Puis supprime les départements
        DB::table('departements')->delete();

        // Réexécute le seeder
        $this->call('db:seed', ['--class' => 'DepartementSeeder']);

        // Restaure les associations
        foreach ($associations as $assoc) {
            $departement = Departement::where('nom', $assoc['departement_nom'])->first();
            if ($departement) {
                ChefDepartement::create([
                    'utilisateur_id' => $assoc['utilisateur_id'],
                    'departement_id' => $departement->id,
                    'status' => 'actif'
                ]);
            }
        }

        $this->info('Les départements ont été nettoyés avec succès.');

        // Affiche la nouvelle liste
        $this->call('departement:list');
    }
}
