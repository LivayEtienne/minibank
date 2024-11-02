<!-- resources/views/components/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    @vite(['resources/css/style.css'])
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>

    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg" style="background-color: #003366; position: fixed; top: 0; width: 100%; z-index: 1000;">
        <a class="navbar-brand" href="#">Tableau de Bord</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <!-- Barre latérale -->
    <div class="text-white p-3" style="background-color: #003366; width: 250px; height: 100vh; position: fixed; top: 0; left:0;">
        <h5>Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('agent.dashboard') }}">
                    <i class="fas fa-home"></i> Accueil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="{{ route('transactions.agent.index') }}">
                    <i class="fas fa-coins"></i> Transactions
                </a>
            </li>

            <!-- Ajoutez ici d'autres éléments du menu si nécessaire -->
            <li class="nav-item">
                <a class="nav-link text-light" href="{{ route('clients.index') }}">
                    <i class="fas fa-users"></i> Listes
                </a>
            </li>
            <!-- Ajoutez d'autres éléments de menu si besoin -->
            <li class="nav-item">
                <a class="nav-link text-light" href="{{ route('clients.archived')}}">
                    <i class="fas fa-users"></i> liste des archivés
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="{{ route('logout')}}" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                            <i class="fas fa-credit-card"></i> Deconnexion
                </a>
            </li>

        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="main-content" style=" margin-top: 70px; width: calc(100% - 80%);">
        <!-- Ajoutez le reste de votre tableau de bord ici -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
