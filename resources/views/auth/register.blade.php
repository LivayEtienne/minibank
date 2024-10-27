<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    @vite(['resources/css/create_compte.css'])
</head>
    <style>
        .avatar {
            width: 100px; /* Largeur de l'avatar */
            height: 100px; /* Hauteur de l'avatar */
            border-radius: 50%; /* Pour rendre l'avatar circulaire */
            object-fit: cover; /* Pour couvrir l'espace sans déformation */
            display: block;
            margin: 0 auto; /* Centrer l'avatar */
        }
        .error {
    color: red;
    font-size: 0.9em;
}

.error-border {
    border-color: red;
}
@keyframes gift-animation {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.gift-message {
    display: none; /* Cacher le message par défaut */
    animation: gift-animation 1s ease-in-out forwards; /* Forwards pour conserver le style final */
}

.fade-in {
    opacity: 0; /* Démarrer avec une opacité de 0 */
    transition: opacity 0.5s ease-in-out; /* Transition douce */
}

.fade-in.show {
    opacity: 1; /* Afficher en douceur */
}

.bounce {
    animation: bounce 0.5s ease-in-out; /* Animation de rebond */
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-30px); /* Monter */
    }
    60% {
        transform: translateY(-15px); /* Descendre légèrement */
    }
}



    </style>
    </head>
    <body>
        @include('dashboard')
        <nav class="navbar navbar-expand-lg">

            </button>
        </nav>

    <div class="container mt-5">
    <h2 class="text-center">Inscription</h2>

    @if (session('success'))
    <div class="alert alert-success fade-in show" id="successMessage">
        {{ session('success') }}
    </div>
@endif


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


    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf

        <div class="form-row">
            <!-- Prénom -->
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input id="prenom" class="form-control" type="text" name="prenom" value="{{ old('prenom') }}" required>
                <div class="error prenom-error"></div>
                @error('prenom')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nom -->
            <div class="form-group">
                <label for="nom">Nom</label>
                <input id="nom" class="form-control" type="text" name="nom" value="{{ old('nom') }}" required>
                <div class="error nom-error"></div>
                @error('nom')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                <div class="error email-error"></div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Téléphone -->
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input id="telephone" class="form-control" type="text" name="telephone" value="{{ old('telephone') }}" required pattern="^7[0-8][0-9]{7}$" title="Le numéro de téléphone doit commencer par 70, 75, 76, 77 ou 78 et contenir 9 chiffres au total.">
                <div class="error telephone-error"></div>
                @error('telephone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="form-row">
            <!-- Date de Naissance -->
        <div class="form-group">
            <label for="date_naissance">Date de Naissance</label>
            <input id="date_naissance" class="form-control" type="date" name="date_naissance" value="{{ old('date_naissance') }}" required max="2000-12-31">
            <div class="error date_naissance-error"></div>
            @error('date_naissance')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


            <!-- Adresse -->
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input id="adresse" class="form-control" type="text" name="adresse" value="{{ old('adresse') }}" required>
                <div class="error adresse-error"></div>
                @error('adresse')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <!-- Carte d'Identité -->
            <div class="form-group">
                <label for="cni">CNI</label>
                <input id="cni" class="form-control" type="text" name="cni" value="{{ old('cni') }}" required>
                <div class="error cni-error"></div>
                @error('cni')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Photo -->
            <div class="form-group">
                <label for="photo">Photo</label>
                <input id="photo" class="form-control mt-2" type="file" name="photo" accept="image/*" onchange="previewAvatar(event)">
                <div class="text-center">
                    <!-- Aperçu de l'avatar -->
                    <img id="avatarPreview" src="{{ asset('photos/avatae.png') }}" alt="Avatar par défaut" class="avatar">
                </div>
                @error('photo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="role">Rôle</label>
            <select id="role" class="form-control" name="role" required>
                <option value="" disabled selected>Choisir un rôle</option>
                <option value="client">Client</option>
                <option value="administrateur">Administrateur</option>
            </select>
            <div class="error role-error"></div>
            @error('role')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <!-- Mot de Passe -->
            <div class="form-group">
                <label for="mot_de_passe">Mot de Passe</label>
                <input id="mot_de_passe" class="form-control" type="password" name="mot_de_passe" required autocomplete="new-password">
                <div class="error mot_de_passe-error"></div>
                @error('mot_de_passe')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirmer le Mot de Passe -->
            <div class="form-group">
                <label for="mot_de_passe_confirmation">Confirmer le Mot de Passe</label>
                <input id="mot_de_passe_confirmation" class="form-control" type="password" name="mot_de_passe_confirmation" required autocomplete="new-password">
                <div class="error mot_de_passe_confirmation-error"></div>
                @error('mot_de_passe_confirmation')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                Annuler
            </a>

            <button type="submit" class="btn btn-primary">
                S’inscrire
            </button>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success fade-in show">
                {{ session('success') }}
            </div>
        @endif
    </form>

    <!-- Inclure le script CDN pour canvas-confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script src="{{ asset('js/confirmation.js') }}"></script>


@vite(['resources/js/confirmation.js'])


<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avatarPreview').src = e.target.result;
    }
    reader.readAsDataURL(file);
}

function launchConfetti() {
    const colors = ['#ff0b00', '#00ff0b', '#000bff', '#ff00e0', '#ff6b00', '#00ff6b']; // Couleurs des confettis
    const particleCount = 200; // Nombre total de confettis
    const spread = 120; // Dispersion des confettis

    const duration = 5000; // Durée totale de l'animation (en ms)
    const animationInterval = 200; // Intervalle entre les lancers (en ms)

    // Intervalle pour lancer les confettis par vagues
    let animationEnd = Date.now() + duration;
    let interval = setInterval(() => {
        if (Date.now() > animationEnd) {
            return clearInterval(interval);
        }

        // Lancer une vague de confettis
        confetti({
            particleCount: particleCount / 10, // Envoi de 20 confettis par vague
            angle: Math.random() * 360, // Angle aléatoire
            spread: spread, // Dispersion
            startVelocity: 30 + Math.random() * 50, // Vitesse initiale aléatoire
            gravity: 0.8, // Gravité pour une chute plus naturelle
            ticks: 200, // Durée de vie des confettis
            colors: colors, // Palette de couleurs
            scalar: 0.8 + Math.random() * 0.4, // Taille aléatoire (entre 0.8 et 1.2)
            origin: {
                x: Math.random(), // Origine aléatoire sur l'axe X
                y: Math.random() * 0.6 // Origine aléatoire entre 0 et 0.6 sur l'axe Y
            }
        });
    }, animationInterval);
}

// Vérifiez si le message de succès est présent
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('successMessage');

    if (successMessage) {
        // Lancer les confettis lorsque le message de succès apparaît
        launchConfetti();
    }
});

</script>
</body>
</html>
