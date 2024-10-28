<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Client</title>
    @vite(['resources/css/affichage.css'])
</head>
<body>
    @include('dashboard')

    <!-- Contenu principal -->
    <div class="main-content" style="margin-left: 250px; margin-top: 70px; width: calc(100% - 250px);">
        <div class="container mt-5">
            <h1>Modifier les informations du client</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Champ Nom -->
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $client->nom) }}" required>
                    <div class="nom-error text-danger"></div>
                </div>

                <!-- Champ Prénom -->
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $client->prenom) }}" required>
                    <div class="prenom-error text-danger"></div>
                </div>

                <!-- Champ Téléphone -->
                <div class="form-group">
                    <label for="telephone">Téléphone :</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $client->telephone) }}">
                    <div class="telephone-error text-danger"></div>
                </div>

                <!-- Champ Date de Naissance -->
                <div class="form-group">
                    <label for="date_naissance">Date de naissance :</label>
                    <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance', $client->date_naissance) }}" required>
                    <div class="date_naissance-error text-danger"></div>
                </div>

                <!-- Champ Adresse -->
                <div class="form-group">
                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $client->adresse) }}" required>
                    <div class="adresse-error text-danger"></div>
                </div>

                <!-- Champ CNI -->
                <div class="form-group">
                    <label for="cni">CNI :</label>
                    <input type="text" name="cni" class="form-control" value="{{ old('cni', $client->cni) }}" required>
                    <div class="cni-error text-danger"></div>
                </div>

                <!-- Champ Rôle -->
                <div class="form-group">
                    <label for="role">Rôle :</label>
                    <select name="role" class="form-control" required>
                        <option value="administrateur" {{ old('role', $client->role) === 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                        <option value="client" {{ old('role', $client->role) === 'client' ? 'selected' : '' }}>Client</option>
                    </select>
                </div>

                <!-- Champ Photo -->
                <div class="form-group">
                    <label for="photo">Photo :</label>
                    <input type="file" name="photo" class="form-control" id="photo">
                    <img id="avatarPreview" src="{{ asset($client->photo) }}" alt="Photo de {{ $client->nom }}" style="margin-top: 10px; width: 100px; height: auto; {{ $client->photo ? '' : 'display: none;' }}" />
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>

            </form>

        </div>
    </div>

    @vite(['resources/js/confirmation.js'])

    <script>
        // Aperçu de l'image sélectionnée
        document.getElementById('photo').addEventListener('change', function(event) {
            const [file] = event.target.files;
            const avatarPreview = document.getElementById('avatarPreview');

            if (file) {
                avatarPreview.src = URL.createObjectURL(file);
                avatarPreview.style.display = 'block';
            } else {
                avatarPreview.style.display = 'none';
            }
        });
    </script>
</body>
</html>
