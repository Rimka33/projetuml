@extends('layouts.admin')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="container-xl">
    <div class="app-card app-card-account shadow-sm d-flex flex-column">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Modifier l'utilisateur</h4>
                </div>
            </div>
        </div>
        <div class="app-card-body px-4 w-100">
            <form method="POST" action="{{ route('admin.update-user', $utilisateur->id) }}" class="settings-form">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror"
                           id="nom" name="nom" value="{{ old('nom', $utilisateur->nom) }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                           id="prenom" name="prenom" value="{{ old('prenom', $utilisateur->prenom) }}" required>
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email', $utilisateur->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                        <option value="actif" {{ $utilisateur->status == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ $utilisateur->status == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Rôle</label>
                    <input type="text" class="form-control" value="{{ ucfirst($utilisateur->role) }}" disabled>
                </div>

                <button type="submit" class="btn app-btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.dashboard') }}" class="btn app-btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
