<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChefDepartement;
use App\Models\Utilisateur;
use App\Models\Departement;

class CheckChefDepartement extends Command
{
    protected $signature = 'check:chef-departement {email}';
    protected $description = 'Vérifie les informations du chef de département';

    public function handle()
    {
        $email = $this->argument('email');

        // Trouver l'utilisateur
        $utilisateur = Utilisateur::where('email', $email)->first();

        if (!$utilisateur) {
            $this->error("Aucun utilisateur trouvé avec l'email : {$email}");
            return 1;
        }

        $this->info("Utilisateur trouvé :");
        $this->table(
            ['ID', 'Nom', 'Email', 'Rôle', 'Status'],
            [[$utilisateur->id, $utilisateur->name, $utilisateur->email, $utilisateur->role, $utilisateur->status]]
        );

        // Trouver le chef de département
        $chefDepartement = ChefDepartement::where('utilisateur_id', $utilisateur->id)->first();

        if (!$chefDepartement) {
            $this->error("Aucune entrée dans la table chef_departements pour cet utilisateur");
            return 1;
        }

        $this->info("\nChef de département trouvé :");
        $this->table(
            ['ID', 'Utilisateur ID', 'Département ID'],
            [[$chefDepartement->id, $chefDepartement->utilisateur_id, $chefDepartement->departement_id]]
        );

        // Vérifier le département
        $departement = Departement::find($chefDepartement->departement_id);

        if (!$departement) {
            $this->error("Aucun département trouvé avec l'ID : {$chefDepartement->departement_id}");
            return 1;
        }

        $this->info("\nDépartement trouvé :");
        $this->table(
            ['ID', 'Nom', 'Status'],
            [[$departement->id, $departement->nom, $departement->status]]
        );

        return 0;
    }
}
