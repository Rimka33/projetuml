<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @php
                        $redirectRoutes = [
                            'admin' => 'admin.dashboard',
                            'chef_departement' => 'chef-departement.dashboard',
                            'professeur' => 'professeur.dashboard',
                            'directeur' => 'directeur.dashboard',
                            'responsable_financier' => 'responsable-financier.dashboard'
                        ];

                        $userRole = auth()->user()->role;
                        if (isset($redirectRoutes[$userRole])) {
                            echo "<script>window.location.href = '" . route($redirectRoutes[$userRole]) . "';</script>";
                        }
                    @endphp
                    {{ __("Vous êtes connecté !") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
