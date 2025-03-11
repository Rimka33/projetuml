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
                    @if(auth()->user()->role === 'admin')
                        <script>window.location.href = "{{ route('admin.dashboard') }}";</script>
                    @else
                        {{ __("Vous êtes connecté !") }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
