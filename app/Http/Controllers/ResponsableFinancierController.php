<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BesoinBudgetaire;
use App\Models\ResponsableFinancier;
use Illuminate\Support\Facades\Auth;
use App\Models\Professeur;

class ResponsableFinancierController extends Controller
{
    public function dashboard()
    {
        try {
            // Vérifier si l'utilisateur est un responsable financier
            $user = Auth::user();
            if ($user->role !== 'responsable_financier') {
                \Log::error('Tentative d\'accès au dashboard du responsable financier par un utilisateur non autorisé', [
                    'user_id' => $user->id,
                    'role' => $user->role
                ]);
                return redirect()->route('login')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
            }

            // Récupérer le responsable financier connecté
            $responsable = ResponsableFinancier::where('utilisateur_id', Auth::id())
                ->with('departement')
                ->firstOrFail();

            \Log::info('Informations du responsable financier', [
                'responsable_id' => Auth::id(),
                'departement_id' => $responsable->departement_id,
                'user_info' => $user->toArray()
            ]);

            // Récupérer les besoins ajoutés par le responsable financier
            $mesBesoins = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->where('utilisateur_id', Auth::id())
                ->with(['validatedBy', 'rejectedBy', 'approvedBy'])
                ->orderBy('created_at', 'desc')
                ->get();

            \Log::info('Mes besoins budgétaires', [
                'count' => $mesBesoins->count(),
                'besoins' => $mesBesoins->map(function($besoin) {
                    return [
                        'id' => $besoin->id,
                        'type' => $besoin->type,
                        'designation' => $besoin->designation,
                        'status' => $besoin->status,
                        'created_at' => $besoin->created_at
                    ];
                })
            ]);

            // Récupérer tous les besoins du département
            $besoins = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->with(['utilisateur', 'validatedBy', 'rejectedBy', 'approvedBy'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            \Log::info('Tous les besoins du département', [
                'count' => $besoins->count(),
                'besoins' => $besoins->map(function($besoin) {
                    return [
                        'id' => $besoin->id,
                        'type' => $besoin->type,
                        'designation' => $besoin->designation,
                        'status' => $besoin->status,
                        'utilisateur_id' => $besoin->utilisateur_id,
                        'created_at' => $besoin->created_at
                    ];
                })
            ]);

            // Statistiques des besoins
            $totalBesoins = BesoinBudgetaire::where('departement_id', $responsable->departement_id)->count();
            $besoinsEnAttente = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->where('status', 'validated_by_chef')
                ->count();
            $besoinsApprouves = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->where('status', 'approved')
                ->count();
            $besoinsRejetes = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->whereIn('status', ['rejected', 'rejected_by_chef'])
                ->count();
            $montantTotal = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->where('status', 'approved')
                ->sum('cout_total');

            // Récupérer les professeurs du département
            $professeurs = Professeur::where('departement_id', $responsable->departement_id)
                ->with('utilisateur')
                ->get();

            return view('responsable-financier.dashboard', compact(
                'besoins',
                'mesBesoins',
                'totalBesoins',
                'besoinsEnAttente',
                'besoinsApprouves',
                'besoinsRejetes',
                'montantTotal',
                'professeurs'
            ));
        } catch (\Exception $e) {
            \Log::error('Erreur dans le dashboard du responsable financier', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()->with('error', 'Une erreur est survenue lors du chargement du tableau de bord : ' . $e->getMessage());
        }
    }

    public function showBesoin($id)
    {
        try {
            $responsable = ResponsableFinancier::where('utilisateur_id', Auth::id())->first();
            $besoin = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->where('id', $id)
                ->with(['utilisateur', 'validatedBy', 'rejectedBy', 'approvedBy'])
                ->firstOrFail();

            // S'assurer que les dates sont des instances Carbon
            if ($besoin->validated_at && !$besoin->validated_at instanceof \Carbon\Carbon) {
                $besoin->validated_at = \Carbon\Carbon::parse($besoin->validated_at);
            }
            if ($besoin->rejected_at && !$besoin->rejected_at instanceof \Carbon\Carbon) {
                $besoin->rejected_at = \Carbon\Carbon::parse($besoin->rejected_at);
            }
            if ($besoin->approved_at && !$besoin->approved_at instanceof \Carbon\Carbon) {
                $besoin->approved_at = \Carbon\Carbon::parse($besoin->approved_at);
            }
            if ($besoin->created_at && !$besoin->created_at instanceof \Carbon\Carbon) {
                $besoin->created_at = \Carbon\Carbon::parse($besoin->created_at);
            }

            return view('responsable-financier.show-besoin', compact('besoin'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'affichage du besoin', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'besoin_id' => $id
            ]);

            return redirect()->route('responsable-financier.dashboard')
                ->with('error', 'Une erreur est survenue lors de l\'affichage du besoin.');
        }
    }

    public function createBesoin()
    {
        return view('responsable-financier.create-besoin');
    }

    public function storeBesoin(Request $request)
    {
        try {
            // Vérifier si l'utilisateur est un responsable financier
            $user = Auth::user();
            if ($user->role !== 'responsable_financier') {
                \Log::error('Tentative de création d\'un besoin par un utilisateur non autorisé', [
                    'user_id' => $user->id,
                    'role' => $user->role
                ]);
                return redirect()->route('login')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
            }

            \Log::info('Début de la création d\'un besoin budgétaire', [
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
                'user_role' => $user->role
            ]);

            // Validation de base pour les champs communs
            $validatedData = $request->validate([
                'type' => 'required|string',
                'periode' => 'required|string|max:255',
                'source_financement' => 'required|string|max:255',
                'priorite' => 'required|in:low,medium,high',
            ]);

            \Log::info('Validation des données de base réussie', [
                'validated_data' => $validatedData,
                'type' => $request->type
            ]);

            // Validation spécifique selon le type de besoin
            if (in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant'])) {
                $additionalData = $request->validate([
                    'designation1' => 'required|string|max:255',
                    'motif1' => 'required|string',
                    'quantite1' => 'required|integer|min:1',
                    'cout_unitaire1' => 'required|numeric|min:0',
                    'cout_total1' => 'required|numeric|min:0',
                ]);
                \Log::info('Validation des données groupe 1 réussie', [
                    'additional_data' => $additionalData,
                    'type' => $request->type
                ]);
            } else {
                $additionalData = $request->validate([
                    'designation2' => 'required|string|max:255',
                    'motif2' => 'required|string',
                    'quantite2' => 'required|integer|min:1',
                    'cout_unitaire2' => 'required|numeric|min:0',
                    'cout_total2' => 'required|numeric|min:0',
                ]);
                \Log::info('Validation des données groupe 2 réussie', [
                    'additional_data' => $additionalData,
                    'type' => $request->type
                ]);
            }

            // Récupérer le responsable financier connecté avec son département
            $responsable = ResponsableFinancier::where('utilisateur_id', Auth::id())
                ->with('departement')
                ->firstOrFail();

            \Log::info('Responsable financier trouvé', [
                'responsable_id' => $responsable->id,
                'departement_id' => $responsable->departement_id,
                'user_info' => $user->toArray()
            ]);

            // Vérifier que le responsable a un département assigné
            if (!$responsable->departement) {
                throw new \Exception('Vous n\'avez pas de département assigné.');
            }

            // Préparer les données pour la création
            $besoinData = [
                'type' => $validatedData['type'],
                'designation' => $additionalData[in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']) ? 'designation1' : 'designation2'],
                'motif' => $additionalData[in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']) ? 'motif1' : 'motif2'],
                'quantite' => $additionalData[in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']) ? 'quantite1' : 'quantite2'],
                'cout_unitaire' => $additionalData[in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']) ? 'cout_unitaire1' : 'cout_unitaire2'],
                'cout_total' => $additionalData[in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']) ? 'cout_total1' : 'cout_total2'],
                'periode' => $validatedData['periode'],
                'source_financement' => $validatedData['source_financement'],
                'priorite' => $validatedData['priorite'],
                'utilisateur_id' => Auth::id(),
                'departement_id' => $responsable->departement_id,
                'status' => 'pending'
            ];

            \Log::info('Données préparées pour la création du besoin', [
                'besoin_data' => $besoinData,
                'type' => $request->type,
                'is_group1' => in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant'])
            ]);

            // Créer le besoin budgétaire
            $besoin = BesoinBudgetaire::create($besoinData);

            \Log::info('Besoin budgétaire créé avec succès', [
                'besoin_id' => $besoin->id,
                'responsable_id' => Auth::id(),
                'departement_id' => $responsable->departement_id,
                'data' => $besoin->toArray()
            ]);

            // Vérifier que le besoin a bien été créé
            $besoinVerification = BesoinBudgetaire::find($besoin->id);
            if (!$besoinVerification) {
                throw new \Exception('Le besoin a été créé mais n\'a pas pu être retrouvé dans la base de données.');
            }

            \Log::info('Vérification du besoin créé réussie', [
                'besoin_verification' => $besoinVerification->toArray()
            ]);

            return redirect()->route('responsable-financier.dashboard')
                ->with('success', 'Le besoin budgétaire a été créé avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation lors de la création du besoin budgétaire', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
                'user_id' => Auth::id()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du besoin budgétaire', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du besoin budgétaire : ' . $e->getMessage());
        }
    }

    public function approveBesoin($id)
    {
        $responsable = ResponsableFinancier::where('utilisateur_id', Auth::id())->first();
        $besoin = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $besoin->status = 'approved_by_rf';
        $besoin->approved_by = Auth::id();
        $besoin->approved_at = now();
        $besoin->save();

        return redirect()->route('responsable-financier.show-besoin', $besoin->id)
            ->with('success', 'Le besoin a été validé et transmis au chef de département pour validation finale.');
    }

    public function rejectBesoin(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:255'
        ]);

        $responsable = ResponsableFinancier::where('utilisateur_id', Auth::id())->first();
        $besoin = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $besoin->status = 'rejected_by_rf';
        $besoin->rejected_by = Auth::id();
        $besoin->rejected_at = now();
        $besoin->motif_rejet = $request->motif_rejet;
        $besoin->save();

        return redirect()->route('responsable-financier.show-besoin', $besoin->id)
            ->with('success', 'Le besoin a été rejeté.');
    }

    public function editBesoin($id)
    {
        try {
            $responsable = ResponsableFinancier::where('utilisateur_id', Auth::id())->first();
            $besoin = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->where('id', $id)
                ->firstOrFail();

            return view('responsable-financier.edit-besoin', compact('besoin'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'édition du besoin budgétaire', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'besoin_id' => $id
            ]);

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'accès au formulaire d\'édition.');
        }
    }

    public function updateBesoin(Request $request, $id)
    {
        try {
            $responsable = ResponsableFinancier::where('utilisateur_id', Auth::id())->first();
            $besoin = BesoinBudgetaire::where('departement_id', $responsable->departement_id)
                ->where('id', $id)
                ->firstOrFail();

            // Déterminer quel groupe de champs est actif
            $isGroup1 = in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']);
            $suffix = $isGroup1 ? '1' : '2';

            // Règles de validation
            $rules = [
                'type' => 'required|string',
                'designation' . $suffix => 'required|string',
                'motif' . $suffix => 'required|string',
                'quantite' . $suffix => 'required|numeric|min:1',
                'cout_unitaire' . $suffix => 'required|numeric|min:0',
                'cout_total' . $suffix => 'required|numeric|min:0',
                'periode' => 'required|string',
                'source_financement' => 'required|string',
                'priorite' => 'required|in:low,medium,high'
            ];

            // Valider les données
            $validatedData = $request->validate($rules);

            // Mettre à jour le besoin budgétaire
            $besoin->update([
                'type' => $validatedData['type'],
                'designation' => $validatedData['designation' . $suffix],
                'motif' => $validatedData['motif' . $suffix],
                'quantite' => $validatedData['quantite' . $suffix],
                'cout_unitaire' => $validatedData['cout_unitaire' . $suffix],
                'cout_total' => $validatedData['cout_total' . $suffix],
                'periode' => $validatedData['periode'],
                'source_financement' => $validatedData['source_financement'],
                'priorite' => $validatedData['priorite']
            ]);

            \Log::info('Besoin budgétaire mis à jour avec succès', [
                'besoin_id' => $besoin->id,
                'responsable_id' => Auth::id(),
                'departement_id' => $responsable->departement_id,
                'data' => $besoin->toArray()
            ]);

            return redirect()->route('responsable-financier.show-besoin', $besoin->id)
                ->with('success', 'Le besoin budgétaire a été mis à jour avec succès.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation lors de la mise à jour du besoin', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
                'besoin_id' => $id
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du besoin budgétaire', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'besoin_id' => $id,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du besoin budgétaire.')
                ->withInput();
        }
    }
}
