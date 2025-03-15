<?php

namespace App\Http\Controllers;

use App\Models\BesoinBudgetaire;
use App\Models\Directeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirecteurController extends Controller
{
    public function dashboard()
    {
        $directeur = Directeur::where('utilisateur_id', auth()->id())->first();

        if (!$directeur) {
            return redirect()->route('dashboard')
                ->with('error', 'Erreur : Directeur non trouvé.');
        }

        $besoins = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('directeur.dashboard', compact('besoins'));
    }

    public function besoins()
    {
        $besoins = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('directeur.besoins', compact('besoins'));
    }

    public function createBesoin()
    {
        return view('directeur.create-besoin');
    }

    public function store(Request $request)
    {
        \Log::info('Début de la méthode store pour le directeur', [
            'request_data' => $request->all()
        ]);

        try {
            // Déterminer quel groupe de champs utiliser
            $isGroup1 = in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']);
            $suffix = $isGroup1 ? '1' : '2';

            $rules = [
                'type' => 'required|string',
                "designation{$suffix}" => 'required|string',
                "quantite{$suffix}" => 'required|numeric|min:1',
                "cout_unitaire{$suffix}" => 'required|numeric|min:0',
                "cout_total{$suffix}" => 'required|numeric|min:0',
                "motif{$suffix}" => 'required|string',
                'periode' => 'required|string',
                'source_financement' => 'required|string',
                'priorite' => 'required|in:low,medium,high',
            ];

            \Log::info('Règles de validation', [
                'rules' => $rules,
                'isGroup1' => $isGroup1,
                'suffix' => $suffix
            ]);

            $validatedData = $request->validate($rules);
            \Log::info('Validation passée avec succès', [
                'validated_data' => $validatedData
            ]);

            $directeur = Directeur::where('utilisateur_id', auth()->id())->first();

            if (!$directeur) {
                \Log::error('Directeur non trouvé', ['user_id' => auth()->id()]);
                return back()->with('error', 'Erreur : Directeur non trouvé.');
            }

            \Log::info('Directeur trouvé', [
                'directeur_id' => $directeur->id,
                'departement_id' => $directeur->departement_id
            ]);

            DB::beginTransaction();

            try {
                \Log::info('Création du besoin avec les données', [
                    'type' => $request->type,
                    'designation' => $request->{"designation$suffix"},
                    'quantite' => $request->{"quantite$suffix"},
                    'cout_unitaire' => $request->{"cout_unitaire$suffix"},
                    'cout_total' => $request->{"cout_total$suffix"},
                    'motif' => $request->{"motif$suffix"},
                    'periode' => $request->periode,
                    'source_financement' => $request->source_financement,
                    'departement_id' => $directeur->departement_id,
                    'utilisateur_id' => auth()->id()
                ]);

                $besoin = BesoinBudgetaire::create([
                    'type' => $request->type,
                    'designation' => $request->{"designation$suffix"},
                    'quantite' => $request->{"quantite$suffix"},
                    'cout_unitaire' => $request->{"cout_unitaire$suffix"},
                    'cout_total' => $request->{"cout_total$suffix"},
                    'motif' => $request->{"motif$suffix"},
                    'description' => $request->{"motif$suffix"}, // Utiliser le motif comme description
                    'periode' => $request->periode,
                    'source_financement' => $request->source_financement,
                    'status' => 'pending',
                    'priorite' => $request->priorite,
                    'departement_id' => $directeur->departement_id,
                    'utilisateur_id' => auth()->id()
                ]);

                \Log::info('Besoin budgétaire créé avec succès', [
                    'besoin_id' => $besoin->id,
                    'type' => $besoin->type,
                    'departement_id' => $besoin->departement_id,
                    'utilisateur_id' => $besoin->utilisateur_id
                ]);

                DB::commit();

                return redirect()->route('directeur.dashboard')
                    ->with('success', 'Besoin budgétaire créé avec succès.');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Erreur lors de la création du besoin', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->with('error', 'Erreur lors de la création du besoin : ' . $e->getMessage());
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        }
    }
}
