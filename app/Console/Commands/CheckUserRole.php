<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Utilisateur;
use App\Models\ChefDepartement;

class CheckUserRole extends Command
{
    protected $signature = 'user:check {email}';
    protected $description = 'Vérifie les informations d\'un utilisateur et ses rôles';

    public function handle()
    {
        $email = $this->argument('email');
        $user = Utilisateur::where('email', $email)->first();

        if (!$user) {
            $this->error("Utilisateur non trouvé avec l'email : {$email}");
            return 1;
        }

        $this->info("Information de l'utilisateur :");
        $this->table(
            ['ID', 'Nom', 'Prénom', 'Email', 'Rôle', 'Status'],
            [[$user->id, $user->nom, $user->prenom, $user->email, $user->role, $user->status]]
        );

        if ($user->role === 'chef_departement') {
            $chefDept = ChefDepartement::where('utilisateur_id', $user->id)->first();
            if ($chefDept) {
                $this->info("Information du chef de département :");
                $this->table(
                    ['ID', 'Utilisateur ID', 'Département ID', 'Status'],
                    [[$chefDept->id, $chefDept->utilisateur_id, $chefDept->departement_id, $chefDept->status]]
                );
            } else {
                $this->error("Aucune entrée trouvée dans la table chef_departements pour cet utilisateur.");
            }
        }

        return 0;
    }
}
