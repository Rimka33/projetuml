@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-xl">
    <div class="app-card app-card-account shadow-sm d-flex flex-column">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Liste des utilisateurs</h4>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.create-user') }}" class="btn app-btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un utilisateur
                    </a>
                </div>
            </div>
        </div>
        <div class="app-card-body px-4 w-100">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utilisateurs as $utilisateur)
                        <tr>
                            <td>{{ $utilisateur->nom }}</td>
                            <td>{{ $utilisateur->prenom }}</td>
                            <td>{{ $utilisateur->email }}</td>
                            <td>
                                @if($utilisateur->role === 'directeur')
                                    <span class="badge bg-info">Directeur</span>
                                @else
                                    <span class="badge bg-info">Chef de département</span>
                                @endif
                            </td>
                            <td>
                                @if($utilisateur->status === 'actif')
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.edit-user', $utilisateur->id) }}" class="btn btn-sm app-btn-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.delete-user', $utilisateur->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
