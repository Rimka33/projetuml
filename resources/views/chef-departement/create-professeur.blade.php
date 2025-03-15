<x-app-layout>
    <div class="container-xl">
        <div class="app-card app-card-account shadow-sm d-flex flex-column">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Ajouter un professeur</h4>
                    </div>
                </div>
            </div>

            <div class="app-card-body px-4 w-100">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="app-page-title mb-0">Ajouter un Professeur</h1>
                        <a href="{{ route('chef-departement.dashboard') }}" class="btn app-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <form method="POST" action="{{ route('chef-departement.store-professeur') }}">
                    @csrf

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                    id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                                    id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12">
                                <label for="specialite" class="form-label">Spécialité</label>
                                <input type="text" class="form-control @error('specialite') is-invalid @enderror"
                                    id="specialite" name="specialite" value="{{ old('specialite') }}" required>
                                @error('specialite')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12">
                                <label for="grade" class="form-label">Grade</label>
                                <select class="form-select @error('grade') is-invalid @enderror"
                                    id="grade" name="grade" required>
                                    <option value="">Sélectionnez un grade</option>
                                    <option value="PA" {{ old('grade') === 'PA' ? 'selected' : '' }}>Professeur Assimilé</option>
                                    <option value="PT" {{ old('grade') === 'PH' ? 'selected' : '' }}>Professeur Titulaire</option>
                                    <option value="PER" {{ old('grade') === 'PER' ? 'selected' : '' }}>PER</option>
                                    <option value="PATS" {{ old('grade') === 'PATS' ? 'selected' : '' }}>PATS</option>
                                </select>
                                @error('grade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input @error('is_responsable_financier') is-invalid @enderror"
                                        type="checkbox" id="is_responsable_financier" name="is_responsable_financier"
                                        {{ old('is_responsable_financier') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_responsable_financier">
                                        Désigner comme Responsable Financier du département
                                    </label>
                                    @error('is_responsable_financier')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a href="{{ route('chef-departement.dashboard') }}" class="btn app-btn-secondary">Annuler</a>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn app-btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
