<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Departement;

class ListDepartements extends Command
{
    protected $signature = 'departement:list';
    protected $description = 'Liste tous les départements';

    public function handle()
    {
        $departements = Departement::all();

        if ($departements->isEmpty()) {
            $this->info('Aucun département trouvé. Exécution du seeder...');
            $this->call('db:seed', ['--class' => 'DepartementSeeder']);
            $departements = Departement::all();
        }

        $this->table(
            ['ID', 'Nom', 'Description', 'Status'],
            $departements->map(function ($dept) {
                return [
                    'id' => $dept->id,
                    'nom' => $dept->nom,
                    'description' => $dept->description,
                    'status' => $dept->status,
                ];
            })
        );
    }
}
