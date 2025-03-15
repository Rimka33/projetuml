<x-app-layout>
    <div class="app-card app-card-account shadow-sm d-flex flex-column">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Liste des Professeurs</h4>
                </div>
                <div class="col-auto">
                    <a href="{{ route('chef-departement.create-professeur') }}" class="btn app-btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un professeur
                    </a>
                </div>
            </div>
        </div>

        <div class="app-card-body px-4 w-100">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    @if(session('initial_password'))
                        <hr>
                        <p class="mb-0"><strong>Mot de passe initial :</strong> {{ session('initial_password') }}</p>
                        <p class="mb-0 text-danger"><small>Veuillez communiquer ce mot de passe au professeur. Il devra le changer à sa première connexion.</small></p>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Spécialité</th>
                            <th>Grade</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($professeurs as $professeur)
                            <tr>
                                <td>{{ $professeur->utilisateur->nom }}</td>
                                <td>{{ $professeur->utilisateur->prenom }}</td>
                                <td>{{ $professeur->utilisateur->email }}</td>
                                <td>{{ $professeur->specialite }}</td>
                                <td>{{ $professeur->grade }}</td>
                                <td>
                                    <span class="badge bg-{{ $professeur->status === 'actif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($professeur->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="#" class="btn btn-sm app-btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="#" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm app-btn-secondary ms-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3">
                                    <div class="alert alert-info mb-0">
                                        Aucun professeur enregistré pour le moment.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($professeurs->hasPages())
                <div class="mt-4">
                    {{ $professeurs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
