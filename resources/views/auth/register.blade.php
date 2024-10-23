<!-- resources/views/auth/register.blade.php -->
<x-guest-layout class="layout">
    @vite(['resources/css/create_compte.css'])
    <div class="container mt-5">
        <h2 class="text-center">Inscription</h2>

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <!-- Prénom -->
                <div class="form-group">
                    <x-input-label for="prenom" :value="__('Prénom')" />
                    <x-text-input id="prenom" class="form-control" type="text" name="prenom" :value="old('prenom')" />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                </div>

                <!-- Nom -->
                <div class="form-group">
                    <x-input-label for="nom" :value="__('Nom')" />
                    <x-text-input id="nom" class="form-control" type="text" name="nom" :value="old('nom')" required />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>
            </div>

            <div class="form-row">
                <!-- Date de Naissance -->
                <div class="form-group">
                    <x-input-label for="date_naissance" :value="__('Date de Naissance')" />
                    <x-text-input id="date_naissance" class="form-control" type="date" name="date_naissance" :value="old('date_naissance')" required />
                    <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
                </div>

                <!-- Téléphone -->
                <div class="form-group">
                    <x-input-label for="telephone" :value="__('Téléphone')" />
                    <x-text-input id="telephone" class="form-control" type="text" name="telephone" :value="old('telephone')" required />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>
            </div>

            <div class="form-row">
                <!-- Adresse -->
                <div class="form-group">
                    <x-input-label for="adresse" :value="__('Adresse')" />
                    <x-text-input id="adresse" class="form-control" type="text" name="adresse" :value="old('adresse')" required />
                    <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                </div>

                <!-- Carte d'Identité -->
                <div class="form-group">
                    <x-input-label for="carte_identite" :value="__('Carte d\'Identité')" />
                    <x-text-input id="carte_identite" class="form-control" type="text" name="carte_identite" :value="old('carte_identite')" required />
                    <x-input-error :messages="$errors->get('carte_identite')" class="mt-2" />
                </div>
            </div>

            <div class="form-row">
                <!-- Photo -->
                <div class="form-group">
                    <x-input-label for="photo" :value="__('Photo')" />
                    <x-text-input id="photo" class="form-control" type="file" name="photo" required />
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>
            </div>

            <div class="form-row">
                <!-- Mot de Passe -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Mot de Passe')" />
                    <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmer le Mot de Passe -->
                <div class="form-group">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le Mot de Passe')" />
                    <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Déjà inscrit ?') }}
                </a>

                <x-primary-button class="btn btn-primary">
                    {{ __('S’inscrire') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
