<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Profile') }}
                </h2>
                <a href="{{
                    auth()->user()->role === 'admin' ? route('admin.dashboard') :
                    (auth()->user()->role === 'directeur' ? route('directeur.dashboard') :
                    (auth()->user()->role === 'chef_departement' ? route('chef-departement.dashboard') :
                    (auth()->user()->role === 'professeur' ? route('professeur.dashboard') : route('dashboard'))))
                }}" class="btn app-btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileImageInput = document.getElementById('profile_image');
            const profileImagePreview = document.querySelector('.profile-image-preview');
            const profileImageForm = document.querySelector('form[action="{{ route('profile.update.image') }}"]');

            if (profileImageInput && profileImagePreview) {
                profileImageInput.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profileImagePreview.src = e.target.result;
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            if (profileImageForm) {
                profileImageForm.addEventListener('submit', function(e) {
                    if (!profileImageInput.files.length) {
                        e.preventDefault();
                        alert('Veuillez sélectionner une image');
                        return false;
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
