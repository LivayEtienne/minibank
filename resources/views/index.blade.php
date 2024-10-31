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
                <span class="navbar-toggler-icon">Deconnexion</span>
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
                    <a class="nav-link text-light" href="{{ route('transactions') }}" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-dollar-sign"></i> Transactions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('clients.index') }}" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-users"></i> Clients
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-user-plus"></i> Distributeurs
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
        <div class="{{ url('/creer_compte') }}" style="margin-left: 250px; margin-top: 70px; width: calc(100% - 250px);">
            <a href="/creer_compte" class="btn-add-admin" style="margin-left: 10px; margin-bottom: 15px; display: inline-block; text-decoration: none;">
                <button style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center;">
                    <!-- Icône + -->
                    <span style="font-weight: bold; font-size: 20px; margin-right: 8px;">+</span>
                    Ajouter un Administrateur
                </button>
            </a>

            <div class="container-fluid">
                <h1 class="mb-4">Bienvenue sur le Tableau de Bord</h1>


                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Nombre d'utilisateurs</h5>
                                    <p class="card-text">7</p>
                                </div>
                                <div class="display-4">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        
                    </div>
                </div>

                <div class="container-fluid mt-4">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nombre Client</h5>
                                    <h2>4</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
        
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                 <h5 class="card-title">Nombre total de distributeurs</h5>
                                    <h2>3</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5 class="text-center">TRANSACTION PAR CLIENT</h5>
                            <div class="chart-container">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
    
                    </div>

                    </div>
                </div>
                <div id="transactionDetails"></div>


                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


                <script>
// Noms des utilisateurs
const userNames = ['Alice', 'Bob', 'Charlie', 'David', 'Eve'];
const numUsers = userNames.length;

// Fonction pour simuler des données de transactions mensuelles pour 5 utilisateurs
function generateMonthlyTransactions(numUsers) {
    const usersData = []; // Tableau pour stocker les données des utilisateurs

    for (let i = 0; i < numUsers; i++) {
        const userName = userNames[i];
        const userFirstName = `FirstName${i + 1}`; // Simuler des prénoms
        const accountNumber = `ACC${i + 1}`; // Simuler des numéros de compte
        const monthlyTransactions = Array(12).fill(0);
        let annualTotal = 0; // Total annuel pour chaque utilisateur
        let annualDistribution = Array(5).fill(0); // Simuler la répartition des revenus sur 5 années

        // Simuler un montant aléatoire pour chaque mois entre 100000 et 1000000
        for (let month = 0; month < 12; month++) {
            const randomAmount = Math.floor(Math.random() * (1000000 - 100000 + 1)) + 100000; // Montant entre 100000 et 1000000
            monthlyTransactions[month] += randomAmount;
            annualTotal += randomAmount; // Ajouter au total annuel
        }

        // Répartition des revenus annuels entre 1 000 000 et 50 000 000
        let totalAnnualRevenue = Math.floor(Math.random() * (50000000 - 1000000 + 1)) + 1000000; // Montant total entre 1 000 000 et 50 000 000
        let remainingRevenue = totalAnnualRevenue;

        for (let year = 0; year < 5; year++) {
            // Répartir le revenu restant aléatoirement sur les années
            const randomYearAmount = Math.floor(Math.random() * (remainingRevenue / (5 - year))) + 1; // Montant aléatoire
            annualDistribution[year] = randomYearAmount;
            remainingRevenue -= randomYearAmount; // Mettre à jour le revenu restant
        }

        // S'assurer que le dernier montant attribué soit le reste du revenu
        annualDistribution[4] += remainingRevenue;

        // Ajouter les données de l'utilisateur dans le tableau
        usersData.push({
            name: userName,
            firstName: userFirstName,
            accountNumber: accountNumber,
            monthlyTransactions: monthlyTransactions,
            annualTotal: totalAnnualRevenue, // Changer le total annuel pour le revenu total
            annualDistribution: annualDistribution // Ajouter la répartition annuelle
        });
    }

    return usersData;
}

var usersData = generateMonthlyTransactions(numUsers); // Générer des données de transactions

// Étiquettes des mois
var moisLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var yearLabels = ['Année 2020', 'Année 2021', 'Année 2022', 'Année 2023', 'Année 2024'];

// Graphique Linéaire pour les Transactions Mensuelles
var ctxLine = document.getElementById('lineChart').getContext('2d');
var lineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: moisLabels,
        datasets: usersData.map((user, index) => ({
            label: user.name,
            data: user.monthlyTransactions,
            backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`,
            borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
            borderWidth: 2,
            fill: true,
            tension: 0.4,
        }))
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Montant (en CFA)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Mois'
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return `${tooltipItem.dataset.label}: ${tooltipItem.raw} CFA`;
                    }
                }
            }
        }
    }
});

// Événement de clic sur le graphique pour afficher les détails
ctxLine.canvas.addEventListener('click', function(event) {
    const activePoints = lineChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, false);
    if (activePoints.length) {
        const { datasetIndex } = activePoints[0];
        const user = usersData[datasetIndex]; // Obtenir les données de l'utilisateur

        // Mettre à jour les graphiques avec les détails de l'utilisateur
        updateDetailGraphs(user);
    }
});

// Fonction pour mettre à jour les graphiques de détails
function updateDetailGraphs(user) {
    // Graphique à Secteurs pour la Répartition des Revenus de l'utilisateur
    var ctxPie = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: yearLabels,
            datasets: [{
                label: `Répartition des Revenus pour ${user.name}`,
                data: user.annualDistribution, // Utiliser la répartition annuelle
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    });

    // Graphique à Barres pour les Détails des Transactions
    var ctxBar = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: yearLabels, // Utiliser les années comme étiquettes
            datasets: [{
                label: `Détails des Transactions pour ${user.name} (Total Annuel: ${user.annualTotal} CFA)`,
                data: user.annualDistribution, // Utiliser la répartition annuelle pour les barres
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Montant (en CFA)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Années'
                    }
                }
            }
        }
    });
}


 </script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
@yield('etiou')
