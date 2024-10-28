<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/style.css'])
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Tableau de Bord</title>
</head>
<body>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tableau de Bord</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    </head>
    <body>

        <!-- Barre de navigation -->
        <nav class="navbar navbar-expand-lg" style="background-color: #003366;">
            <a class="navbar-brand" href="#">Tableau de Bord</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>

        <!-- Barre latérale -->
        <div class="text-white p-3" style="background-color: #003366; width: 250px; height: 100vh; position: fixed; top: 0;">
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
                        <i class="fas fa-box"></i> Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-shopping-cart"></i> Commandes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-cogs"></i> Paramètres
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-dollar-sign"></i> Transactions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-users"></i> Clients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-user-plus"></i> Distributeurs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-credit-card"></i> Créditer un Compte
                    </a>
                </li>
            </ul>


        </div>


        <!-- Contenu principal -->
        <div class="{{ url('/auth/login') }}" style="margin-left: 250px; margin-top: 70px; width: calc(100% - 250px);">
            <a href="/auth/login" class="btn-add-admin" style="margin-left: 10px; margin-bottom: 15px; display: inline-block; text-decoration: none;">
                <button style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center;">
                    <!-- Icône + -->
                    <span style="font-weight: bold; font-size: 20px; margin-right: 8px;">+</span>
                    Ajouter un Administrateur
                </button>
            </a>

            <div class="container-fluid">
                <h1 class="mb-4">Bienvenue sur le Tableau de Bord</h1>

                <!-- Barre de recherche -->
                <form class="form-inline mb-4">
                    <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
                    <button class="btn btn-dark my-2 my-sm-0" type="submit">Rechercher</button>
                </form>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Nombre d'utilisateurs</h5>
                                    <p class="card-text">150</p>
                                </div>
                                <div class="display-4">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card text-white bg-success">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Nombre de commandes</h5>
                                    <p class="card-text">200</p>
                                </div>
                                <div class="display-4">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid mt-4">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Total</h5>
                                    <h2>12,000,000 fc</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Total des ventes</h5>
                                    <h2>2,38,485</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nombre total de distributeurs</h5>
                                    <h2>84,382</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5 class="text-center">Statistiques des Ventes</h5>
                            <div class="chart-container">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-center">Répartition des Revenus</h5>
                            <div class="chart-container">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5 class="text-center">Affaires Perdues</h5>
                            <div class="chart-container">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-center">Objectifs du Trimestre</h5>
                            <div class="chart-container">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                @vite(['resources/js/chart.js'])

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>