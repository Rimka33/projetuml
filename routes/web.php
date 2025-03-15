<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChefDepartementController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\DirecteurController;
use App\Http\Controllers\ResponsableFinancierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes pour les utilisateurs authentifiés
Route::middleware(['auth', 'redirect.role'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.update.image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour l'administrateur
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/create-user', [AdminController::class, 'createUser'])->name('admin.create-user');
    Route::post('/admin/store-user', [AdminController::class, 'storeUser'])->name('admin.store-user');
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::put('/admin/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.update-user');
    Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

// Routes pour les chefs de département
Route::middleware(['auth', 'role:chef_departement'])->group(function () {
    Route::get('/chef-departement/dashboard', [ChefDepartementController::class, 'dashboard'])->name('chef-departement.dashboard');
    Route::get('/chef-departement/besoins', [ChefDepartementController::class, 'besoins'])->name('chef-departement.besoins');
    Route::get('/chef-departement/besoins/create', [ChefDepartementController::class, 'createBesoin'])->name('chef-departement.create-besoin');
    Route::post('/chef-departement/besoins', [ChefDepartementController::class, 'storeBesoin'])->name('chef-departement.store-besoin');
    Route::get('/chef-departement/besoins/{id}', [ChefDepartementController::class, 'showBesoin'])->name('chef-departement.show-besoin');
    Route::post('/chef-departement/besoins/{id}/validate', [ChefDepartementController::class, 'validateBesoin'])->name('chef-departement.validate-besoin');
    Route::post('/chef-departement/besoins/{id}/reject', [ChefDepartementController::class, 'rejectBesoin'])->name('chef-departement.reject-besoin');
    Route::get('/chef-departement/professeurs', [ChefDepartementController::class, 'professeurs'])->name('chef-departement.professeurs');
    Route::get('/chef-departement/professeurs/create', [ChefDepartementController::class, 'createProfesseur'])->name('chef-departement.create-professeur');
    Route::post('/chef-departement/professeurs', [ChefDepartementController::class, 'storeProfesseur'])->name('chef-departement.store-professeur');
    Route::get('/besoins/{id}/edit', [ChefDepartementController::class, 'editBesoin'])->name('chef-departement.edit-besoin');
    Route::put('/besoins/{id}', [ChefDepartementController::class, 'updateBesoin'])->name('chef-departement.update-besoin');
    Route::delete('/besoins/{id}', [ChefDepartementController::class, 'deleteBesoin'])->name('chef-departement.delete-besoin');
});

// Routes pour les professeurs
Route::middleware(['auth', 'role:professeur'])->group(function () {
    Route::get('/professeur/dashboard', [ProfesseurController::class, 'dashboard'])->name('professeur.dashboard');
    Route::get('/professeur/besoins', [ProfesseurController::class, 'besoins'])->name('professeur.besoins');
    Route::get('/professeur/besoins/create', [ProfesseurController::class, 'createBesoin'])->name('professeur.create-besoin');
    Route::post('/professeur/besoins', [ProfesseurController::class, 'storeBesoin'])->name('professeur.store-besoin');
    Route::get('/professeur/besoins/{id}', [ProfesseurController::class, 'showBesoin'])->name('professeur.show-besoin');
});

// Routes pour le directeur
Route::middleware(['auth', 'role:directeur'])->group(function () {
    Route::get('/directeur/dashboard', [DirecteurController::class, 'dashboard'])->name('directeur.dashboard');
    Route::get('/directeur/besoins', [DirecteurController::class, 'besoins'])->name('directeur.besoins');
    Route::get('/directeur/create-besoin', [DirecteurController::class, 'createBesoin'])->name('directeur.create-besoin');
    Route::post('/directeur/store', [DirecteurController::class, 'store'])->name('directeur.store');
});

// Routes pour le responsable financier
Route::middleware(['auth', 'role:responsable_financier'])->group(function () {
    Route::get('/responsable-financier/dashboard', [ResponsableFinancierController::class, 'dashboard'])->name('responsable-financier.dashboard');
    Route::get('/responsable-financier/besoins/create', [ResponsableFinancierController::class, 'createBesoin'])->name('responsable-financier.create-besoin');
    Route::post('/responsable-financier/besoins', [ResponsableFinancierController::class, 'storeBesoin'])->name('responsable-financier.store-besoin');
    Route::get('/responsable-financier/besoins/{id}', [ResponsableFinancierController::class, 'showBesoin'])->name('responsable-financier.show-besoin');
    Route::get('/responsable-financier/besoins/{id}/edit', [ResponsableFinancierController::class, 'editBesoin'])->name('responsable-financier.edit-besoin');
    Route::put('/responsable-financier/besoins/{id}', [ResponsableFinancierController::class, 'updateBesoin'])->name('responsable-financier.update-besoin');
    Route::put('/responsable-financier/besoins/{id}/approve', [ResponsableFinancierController::class, 'approveBesoin'])->name('responsable-financier.approve-besoin');
    Route::post('/responsable-financier/besoins/{id}/reject', [ResponsableFinancierController::class, 'rejectBesoin'])->name('responsable-financier.reject-besoin');
});

require __DIR__.'/auth.php';
