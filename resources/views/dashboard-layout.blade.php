<!-- resources/views/layouts/dashboard-layout.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tableau de Bord')</title>

    <style>
        /* Ajoutez ici votre CSS global */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background-color: #003366;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            color: white;
        }
        .sidebar h5 {
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: white;
            text-decoration: none;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Barre latérale -->
    <div class="sidebar">
        <h5>Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-home"></i> Accueil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                    <i class="fas fa-users"></i> Utilisateurs
                </a>
            </li>

    
            <li class="nav-item">
                <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                    <i class="fas fa-cogs"></i> Paramètres
                </a>
            </li>
            <!-- Ajouter d'autres liens de menu ici -->
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
