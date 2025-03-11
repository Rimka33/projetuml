<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un utilisateur administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nom = $this->ask('Quel est le nom de l\'administrateur ?');
        $prenom = $this->ask('Quel est le prénom de l\'administrateur ?');
        $email = $this->ask('Quel est l\'email de l\'administrateur ?');
        $password = $this->secret('Quel est le mot de passe de l\'administrateur ?');

        $admin = new Utilisateur();
        $admin->nom = $nom;
        $admin->prenom = $prenom;
        $admin->email = $email;
        $admin->password = Hash::make($password);
        $admin->role = 'admin';
        $admin->status = 'actif';
        $admin->date_creation = now();
        $admin->created_by = 0; // Auto-créé
        $admin->save();

        $this->info('Administrateur créé avec succès !');
        $this->info('Email: ' . $email);
        $this->info('Vous pouvez maintenant vous connecter avec ces identifiants.');
    }
}
