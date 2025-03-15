@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="container-xl">
    <div class="app-card app-card-account shadow-sm d-flex flex-column">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Créer un nouvel utilisateur</h4>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.dashboard') }}" class="btn app-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
        <div class="app-card-body px-4 w-100">
            <form method="POST" action="{{ route('admin.store-user') }}" class="settings-form">
                @csrf
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror"
                           id="nom" name="nom" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                           id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select class="form-select @error('role') is-invalid @enderror"
                            id="role" name="role" required>
                        <option value="">Sélectionner un rôle</option>
                        <option value="directeur" {{ old('role') == 'directeur' ? 'selected' : '' }}>Directeur</option>
                        <option value="chef_departement" {{ old('role') == 'chef_departement' ? 'selected' : '' }}>Chef de département</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="departement-section" style="display: none;">
                    <label for="departement_id" class="form-label">Département</label>
                    <select class="form-select @error('departement_id') is-invalid @enderror"
                            id="departement_id" name="departement_id">
                        <option value="">Sélectionner un département</option>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}" {{ old('departement_id') == $departement->id ? 'selected' : '' }}>
                                {{ $departement->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('departement_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe (optionnel)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password">
                    <div class="form-text">Si non renseigné, un mot de passe sera généré automatiquement.</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn app-btn-primary">Créer l'utilisateur</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const departementSection = document.getElementById('departement-section');

    function toggleDepartementSection() {
        if (roleSelect.value === 'chef_departement') {
            departementSection.style.display = 'block';
            document.getElementById('departement_id').required = true;
        } else {
            departementSection.style.display = 'none';
            document.getElementById('departement_id').required = false;
        }
    }

    roleSelect.addEventListener('change', toggleDepartementSection);
    toggleDepartementSection(); // Pour l'état initial
});
</script>
@endpush
@endsection
