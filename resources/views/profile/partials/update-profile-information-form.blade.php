<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Photo de profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Mettez à jour votre photo de profil.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.image') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="text-center mb-4">
            <div class="profile-image-container mb-3">
                <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : asset('assets/images/user.png') }}"
                     alt="Photo de profil"
                     class="rounded-circle profile-image-preview"
                     style="width: 150px; height: 150px; object-fit: cover;">
            </div>
            <div class="profile-image-upload">
                <label for="profile_image" class="btn app-btn-secondary">
                    <i class="fas fa-camera me-2"></i>Changer la photo
                </label>
                <input type="file"
                       id="profile_image"
                       name="profile_image"
                       class="d-none"
                       accept="image/*">
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer la photo') }}</x-primary-button>

            @if (session('status') === 'profile-image-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Photo enregistrée.') }}</p>
            @endif
        </div>
    </form>
</section>

<section class="mt-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Mettez à jour vos informations personnelles.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nom" :value="__('Nom')" />
            <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $user->nom)" required autofocus autocomplete="nom" />
            <x-input-error class="mt-2" :messages="$errors->get('nom')" />
        </div>

        <div>
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full" :value="old('prenom', $user->prenom)" required autocomplete="prenom" />
            <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>
