<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface de Connexion</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/connexion.css'])
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100">
            <!-- Section gauche : Connexion -->
            <div class="col-md-7 d-flex flex-column justify-content-start p-5 bg-light shadow-sm rounded-start">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                </div>
                <h2 class="text-center mb-4">Connexion</h2>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf <!-- Ajoutez le token CSRF pour la sécurité -->
                    
                    <div class="mb-3">
                        <input type="text" class="form-control" name="telephone" 
                               placeholder="Veuillez entrer votre numéro" 
                               value="{{ old('telephone') }}" required>
                        <div id="telephoneError" class="text-danger" style="display:none;"></div>
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" 
                               placeholder="Veuillez entrer votre mot de passe" required>
                        <div id="passwordError" class="text-danger" style="display:none;"></div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark">Se Connecter</button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="text-muted">Mot de passe oublié?</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Section droite : Bienvenue -->
        <div class="col-md-5 d-none d-md-flex flex-column justify-content-end align-items-center bg-light bg-gradient rounded-end">
            <h1 class="display-4 mb-5">BIENVENUE</h1>
            <img src="{{ asset('images/door.jpg') }}" alt="Illustration" class="img-fluid" style="max-width: 80%;">
        </div>
    </div>

    <!-- Ajoutez le script Vite pour le rendu dynamique -->
    @vite(['resources/js/connexion.js'])

    <!-- Lien vers Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>