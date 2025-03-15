<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChefDepartement;
use App\Models\Departement;
use App\Models\Utilisateur;

class AssociateDepartementChef extends Command
{
    protected $signature = 'departement:associate-chef {email} {departement_id}';
    protected $description = 'Associe un chef de département à un département';

    public function handle()
    {
        $email = $this->argument('email');
        $departementId = $this->argument('departement_id');

        $utilisateur = Utilisateur::where('email', $email)->first();
        if (!$utilisateur) {
            $this->error("Utilisateur avec l'email {$email} non trouvé.");
            return 1;
        }

        $departement = Departement::find($departementId);
        if (!$departement) {
            $this->error("Département avec l'ID {$departementId} non trouvé.");
            return 1;
        }

        $chefDepartement = ChefDepartement::where('utilisateur_id', $utilisateur->id)->first();
        if (!$chefDepartement) {
            $chefDepartement = new ChefDepartement();
            $chefDepartement->utilisateur_id = $utilisateur->id;
            $chefDepartement->status = 'actif';
        }

        $chefDepartement->departement_id = $departement->id;
        $chefDepartement->save();

        $this->info("Chef de département associé avec succès au département {$departement->nom}");
        return 0;
    }
}
